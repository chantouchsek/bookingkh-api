<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Super Admin,Admin,User');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach ($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);
                if ($role->name === 'Super Admin') {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } elseif ($role->name === 'Admin') {
                    $permissions = Permission::where('name', 'LIKE', 'view_%')
                        ->orWhere('name', 'LIKE', 'add_%')
                        ->orWhere('name', 'LIKE', 'edit_%')
                        ->get();
                    $role->syncPermissions($permissions);
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }
                // create one user for each role
                $this->createUser($role);
            }
            $this->command->info('Roles '.$input_roles.' added successfully');
        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Added only default user role.');
        }

        // now lets seed some posts for demo
        // factory(\App\Post::class, 30)->create();
        // $this->command->info('Some Posts data seeded.');
        $this->command->warn('All done :)');
    }

    /**
     * Create a user with given role.
     *
     * @param $role
     */
    private function createUser($role)
    {
        $user = factory(User::class)->create();
        $user->assignRole($role->name);

        if ($role->name == 'Super Admin') {
            User::first()->assignRole($role->name);
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }

        if ($role->name == 'Admin') {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }
    }
}

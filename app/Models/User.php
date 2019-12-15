<?php

namespace App\Models;

use Eloquent;
use Laravel\Passport\Token;
use Laravel\Passport\Client;
use Spatie\Sluggable\HasSlug;
use Illuminate\Support\Carbon;
use Cog\Laravel\Ban\Models\Ban;
use Spatie\Sluggable\SlugOptions;
use Laravel\Passport\HasApiTokens;
use Cog\Laravel\Ban\Traits\Bannable;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Traits\Friendable;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanVote;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Cog\Laravel\Love\Reacter\Models\Reacter;
use Illuminate\Database\Eloquent\Collection;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Overtrue\LaravelFollow\Traits\CanBookmark;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Spatie\Image\Exceptions\InvalidManipulation;
use Illuminate\Notifications\DatabaseNotification;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Hootlex\Friendships\Models\FriendFriendshipGroups;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableContract;

/**
 * App\Models\User.
 *
 * @OA\Schema (
 *   schema="Auth",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           required={"email", "password"},
 *           @OA\Property(property="email", type="string", default="chantouchsek.cs83@gmail.com"),
 *           @OA\Property(property="password", type="string", default="password")
 *       )
 *   }
 * )
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $slug
 * @property int|null $love_reacter_id
 * @property string|null $banned_at
 * @property-read Collection|Ban[] $bans
 * @property-read int|null $bans_count
 * @property-read Collection|User[] $followers
 * @property-read int|null $followers_count
 * @property-read Collection|Friendship[] $friends
 * @property-read int|null $friends_count
 * @property-read Collection|FriendFriendshipGroups[] $groups
 * @property-read int|null $groups_count
 * @property-read Reacter|null $loveReacter
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @method static Builder|User whereBannedAt($value)
 * @method static Builder|User whereLoveReacterId($value)
 * @method static Builder|User whereSlug($value)
 */
class User extends Authenticatable implements MustVerifyEmail, ReacterableContract, HasMedia, BannableContract
{
    use Notifiable,
        HasApiTokens,
        HasRoles,
        HasSlug,
        CanFollow,
        CanBeFollowed,
        CanBookmark,
        CanLike,
        CanFavorite,
        CanSubscribe,
        CanVote,
        Friendable,
        Reacterable,
        HasMediaTrait,
        Bannable,
        SnoozeNotifiable;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * @var int
     */
    public $rate_limit = 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'love_reacter_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determine if BannedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyBannedAtScope()
    {
        return true;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate()
            ->usingLanguage(app()->getLocale());
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->sharpen(10);
    }
}

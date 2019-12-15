<?php

namespace App\Models;

use Eloquent;
use Spatie\Sluggable\HasSlug;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Cog\Flag\Traits\Classic\HasActiveFlag;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Overtrue\LaravelFollow\Traits\CanBeVoted;
use Cog\Laravel\Love\Reactant\Models\Reactant;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Overtrue\LaravelFollow\Traits\CanBeBookmarked;
use Cog\Contracts\Love\Reacterable\Models\Reacterable;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;

/**
 * Class Category.
 *
 * @property int $id
 * @property array $title
 * @property string $slug
 * @property array|null $description
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $translations
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereTitle($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereUserId($value)
 * @mixin Eloquent
 * @property int|null $love_reactant_id
 * @property bool $is_active
 * @property-read Collection|User[] $bookmarkers
 * @property-read int|null $bookmarkers_count
 * @property-read Collection|User[] $downvoters
 * @property-read int|null $downvoters_count
 * @property-read Collection|User[] $favoriters
 * @property-read int|null $favoriters_count
 * @property-read Collection|User[] $likers
 * @property-read int|null $likers_count
 * @property-read Reactant|null $loveReactant
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Collection|User[] $upvoters
 * @property-read int|null $upvoters_count
 * @property-read Collection|User[] $voters
 * @property-read int|null $voters_count
 * @method static bool|null forceDelete()
 * @method static Builder|Category joinReactionCounterOfType($reactionTypeName, $alias = null)
 * @method static Builder|Category joinReactionTotal($alias = null)
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Category whereIsActive($value)
 * @method static Builder|Category whereLoveReactantId($value)
 * @method static Builder|Category whereNotReactedBy(Reacterable $reacterable, $reactionTypeName = null)
 * @method static Builder|Category whereReactedBy(Reacterable $reacterable, $reactionTypeName = null)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 */
class Category extends BaseModel implements ReactableContract, HasMedia
{
    use HasSlug,
        SoftDeletes,
        CanBeLiked,
        CanBeFavorited,
        CanBeVoted,
        CanBeBookmarked,
        Reactable,
        HasMediaTrait,
        HasActiveFlag;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'description',
        'love_reactant_id',
        'is_active',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'user_id' => 'integer',
        'description' => 'string',
    ];

    /**
     * @var array
     */
    public $translatable = ['title', 'description', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate()
            ->usingLanguage(app()->getLocale());
    }
}

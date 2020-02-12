<?php

namespace App\Models;

use App\Traits\FiltrableTrait;
use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

class ProductCategories extends Model implements Sortable, HasMedia
{
    use SluggableTrait, SortableTrait, HasTranslations, TranslatableTrait, FiltrableTrait, MediaTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];
    public $translatable = [
        'title'
    ];

    protected $fillable = [
        'slug',
        'title',
        'sort_order'
    ];
    protected $filtrable = 'product_category';

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * @param  Media|null  $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 360, 360)
            ->width(360)
            ->height(360)
            ->sharpen(10);

        $this->addMediaConversion('banner')
            ->fit(Manipulations::FIT_CROP, 1920, 1080)
            ->width(1920)
            ->height(1080)
            ->sharpen(10);
    }

    /**
     * @param  string  $collection
     * @return string
     */
    public function getThumb($collection = 'cover')
    {
        if ($this->hasMedia($collection)) {
            return $this->getFirstMedia($collection)->getFullUrl('thumb');
        }

        return asset('images/no-image.png');
    }

    /**
     * @param  string  $collection
     * @return string
     */
    public function getBanner($collection = 'cover')
    {
        if ($this->hasMedia($collection)) {
            return $this->getFirstMedia($collection)->getFullUrl('banner');
        }

        return asset('images/no-image.png');
    }


    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('sortById', function (Builder $builder) {
            $builder->orderBy('sort_order');
        });
    }
}

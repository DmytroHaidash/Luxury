<?php

namespace App\Models;

use App\Traits\FiltrableTrait;
use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'parent_id',
        'sort_order'
    ];
    protected $filtrable = 'product_category';

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProductCategories::class, 'parent_id');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id','product_id' );
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOnlyParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('sortById', function (Builder $builder) {
            $builder->orderBy('sort_order');
        });
    }
}

<?php

namespace App\Models;

use App\Traits\FiltrableTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class ProductCategories extends Model implements Sortable
{
    use SluggableTrait, SortableTrait, HasTranslations, TranslatableTrait, FiltrableTrait;

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

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('sortById', function (Builder $builder) {
            $builder->orderBy('sort_order');
        });
    }
}

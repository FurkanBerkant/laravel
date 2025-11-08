<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $sku
 * @property numeric $price
 * @property numeric|null $cost_price
 * @property numeric|null $compare_price
 * @property numeric|null $discount_percentage
 * @property int $stock
 * @property int $min_stock
 * @property bool $track_stock
 * @property string $stock_status
 * @property numeric|null $weight
 * @property numeric|null $length
 * @property numeric|null $width
 * @property numeric|null $height
 * @property string|null $main_image
 * @property array<array-key, mixed>|null $images
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property array<array-key, mixed>|null $meta_keywords
 * @property bool $is_active
 * @property bool $is_featured
 * @property int $view_count
 * @property int $order
 * @property array<array-key, mixed>|null $attributes
 * @property Carbon|null $published_at
 * @property Carbon|null $deleted_at
 * @property-read Category $category
 * @property-read array $all_images_urls
 * @property-read mixed $final_price
 * @property-read string $main_image_url
 * @property-read int|float $profit_margin
 * @property-read string $stock_badge
 * @method static Builder<static>|Product active()
 * @method static Builder<static>|Product byCategory($categoryId)
 * @method static Builder<static>|Product featured()
 * @method static Builder<static>|Product inStock()
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product onlyTrashed()
 * @method static Builder<static>|Product priceRange($min, $max)
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereAttributes($value)
 * @method static Builder<static>|Product whereCategoryId($value)
 * @method static Builder<static>|Product whereComparePrice($value)
 * @method static Builder<static>|Product whereCostPrice($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDeletedAt($value)
 * @method static Builder<static>|Product whereDiscountPercentage($value)
 * @method static Builder<static>|Product whereHeight($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImages($value)
 * @method static Builder<static>|Product whereIsActive($value)
 * @method static Builder<static>|Product whereIsFeatured($value)
 * @method static Builder<static>|Product whereLength($value)
 * @method static Builder<static>|Product whereMainImage($value)
 * @method static Builder<static>|Product whereMetaDescription($value)
 * @method static Builder<static>|Product whereMetaKeywords($value)
 * @method static Builder<static>|Product whereMetaTitle($value)
 * @method static Builder<static>|Product whereMinStock($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product whereOrder($value)
 * @method static Builder<static>|Product wherePrice($value)
 * @method static Builder<static>|Product wherePublishedAt($value)
 * @method static Builder<static>|Product whereSku($value)
 * @method static Builder<static>|Product whereSlug($value)
 * @method static Builder<static>|Product whereStock($value)
 * @method static Builder<static>|Product whereStockStatus($value)
 * @method static Builder<static>|Product whereTrackStock($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @method static Builder<static>|Product whereViewCount($value)
 * @method static Builder<static>|Product whereWeight($value)
 * @method static Builder<static>|Product whereWidth($value)
 * @method static Builder<static>|Product withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Product withoutTrashed()
 * @property string|null $long_description
 * @property string|null $description
 * @property int $brand_id
 * @property-read \App\Models\Brand $brand
 * @method static Builder<static>|Product whereBrandId($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereLongDescription($value)
 * @mixin \Eloquent
 */
class Product extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description',
        'long_description',
        'price',
        'cost_price',
        'compare_price',
        'discount_percentage',
        'stock',
        'min_stock',
        'track_stock',
        'stock_status',
        'weight',
        'length',
        'width',
        'height',
        'main_image',
        'images',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_featured',
        'view_count',
        'order',
        'attributes',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'track_stock' => 'boolean',
        'images' => 'array',
        'meta_keywords' => 'array',
        'attributes' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock')
            ->where('stock', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function getMainImageUrlAttribute(): string
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        return asset('images/default-product.png');
    }

    public function getAllImagesUrlsAttribute(): array
    {
        $urls = [$this->main_image_url];

        if ($this->images) {
            foreach ($this->images as $image) {
                $urls[] = asset('storage/' . $image);
            }
        }

        return $urls;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percentage > 0) {
            return $this->price - ($this->price * $this->discount_percentage / 100);
        }
        return $this->price;
    }

    public function getProfitMarginAttribute(): float|int
    {
        if ($this->cost_price > 0) {
            return (($this->price - $this->cost_price) / $this->cost_price) * 100;
        }
        return 0;
    }

    public function getStockBadgeAttribute(): string
    {
        return match($this->stock_status) {
            'in_stock' => '<span class="badge bg-success">Stokta</span>',
            'out_of_stock' => '<span class="badge bg-danger">Tükendi</span>',
            'on_backorder' => '<span class="badge bg-warning">Ön Sipariş</span>',
            default => '<span class="badge bg-secondary">Bilinmiyor</span>',
        };
    }

    public function setPriceAttribute($value): void
    {
        $value = str_replace(['.', ','], ['', '.'], $value);
        $this->attributes['price'] = $value;
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function decreaseStock($quantity = 1): void
    {
        if ($this->track_stock) {
            $this->decrement('stock', $quantity);

            if ($this->stock <= 0) {
                $this->update(['stock_status' => 'out_of_stock']);
            }
        }
    }

    public function increaseStock($quantity = 1): void
    {
        if ($this->track_stock) {
            $this->increment('stock', $quantity);

            if ($this->stock > 0) {
                $this->update(['stock_status' => 'in_stock']);
            }
        }
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}

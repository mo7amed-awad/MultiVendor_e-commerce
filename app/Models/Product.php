<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    protected static function booted()//global code to the model
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }
        });

        // static::creating(function (Product $product) {
        //     $product->slug = Str::slug($product->name);
        // });
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFilter(Builder $builder,$filters){ //local scope must start with scope keyword

        $builder->when($filters['name'] ?? false,function($builder,$value){
            $builder->where('name','LIKE',"%{$value}%");
        });
            //=
        if($filters['status'] ?? false){
            $builder->where('status',$filters['status']);
        }

    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    //Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }

        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

//     public function scopeFilter(Builder $builder, $filters)
//     {
//         $options = array_merge([
//             'store_id' => null,
//             'category_id' => null,
//             'tag_id' => [],
//             'status' => 'active',
//         ], $filters);

//         $builder->when($options['status'], function ($query, $status) {
//             return $query->where('status', $status);
//         });
//         $builder->when($options['store_id'], function ($builder, $value) {
//             $builder->where('store_id', $value);
//         });

//         $builder->when($options['category_id'], function ($builder, $value) {
//             $builder->where('category_id', $value);
//         });

//         $builder->when($options['tag_id'], function ($builder, $value) {
//             $builder->whereExists(function ($query) use ($value) {
//                 $query->select(1)
//                     ->from('product_tag')
//                     ->whereRaw('product_id = products.id')
//                     ->where('tag_id', $value);
//             });
//         });
//     }
}

<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'image', 'parent_id', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id');
    }
    
    public function childern(){
        return $this->hasMany(Category::class,'parent_id','id');
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

    
    public static function rules($id = 0)
    {
        return [

            'name'     => [
                'required',
                'string',
                'min:3',
                'max:255',
                // "unique:categories,name,$id"//unique take three parameter first to table name second for column that i want to not reapet third for except column
                //==
                Rule::unique('categories', 'name')->ignore($id),
                //custom validation
                function ($attribute, $value, $fails) {
                    if (strtolower($value) == 'laravel') {
                        $fails('This name is forbidden');
                    }
                    //you can made it in seperate calss
                },
                new Filter('mohamed'),
                'filter'
            ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image'    => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status'   => 'in:active,archived'

        ];
    }
}

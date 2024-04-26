<?php
// In the Category.php model file

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasApiTokens, HasFactory, Sluggable;
    protected $fillable = [
        'id',
        'title',
        'slug',
        'parent_id',
        'category_id',
        'description',
        'meta_title',
        'meta_desc',
        'meta_key',
        'status',
        'image',
        'icon',
        'banner',
        'top',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
    public function tree()
    {
        return $this->hasMany(Category::class, 'parent_id','id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id','id')->with('children');;
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'categories_attribute','categories_id','attribute_id');
    }


    public function parent()
    {
        return $this->hasOne(Category::class, 'id','parent_id');
    }
    public function parent2()
    {
        return $this->hasMany(Category::class, 'id','parent_id')->select('id','parent_id');
    }
    public function allParents() {
        return $this->parent2()->with('allParents', function ($q){
            $q->select('id','parent_id');
        });
}
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }



}

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
        return $this->hasMany(Attribute::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }



}

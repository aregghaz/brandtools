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
    protected $fillable = ['title', 'slug'];
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

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function getSubcategoriesId(array &$subcategoriesId, $category = null)
    {
        if ($category === null) {
            foreach ($this->subcategories as $subcategory) {
                $subcategoriesId[] = $subcategory->id;
                $this->getSubcategoriesId($subcategoriesId, $subcategory);
            }
        } else {
            foreach ($category->subcategories as $subcategory) {
                $subcategoriesId[] = $subcategory->id;
                $this->getSubcategoriesId($subcategoriesId, $subcategory);
            }
        }
    }
}

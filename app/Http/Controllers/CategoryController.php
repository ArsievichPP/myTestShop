<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::query()->with('subcategories')->whereNull('parent_id')->get();
        return view('categories', ['categories' => $categories]);
    }

    public function show($id)
    {
        $category = Category::query()->find($id);
        $subcategoriesId[] = $category->id;
        $category->getSubcategoriesId($subcategoriesId);
        $products = Product::query()->whereIn('category_id', $subcategoriesId)->simplePaginate(8);
        return view('products', ['products' => $products, 'categories' => $category->subcategories]);
    }
}

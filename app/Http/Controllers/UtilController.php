<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\ReturnType;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    use ReturnType;

    public function getAllCategories()
    {
        $allCategories = Category::all();
        return $this->returnData('categories', $allCategories);
    }
    public function getAllSectionProduct($secName)
    {
        $section = Category::where('category_name', 'like', $secName)->first();
        info($secName);
        $prods = Product::where('category_id', $section->id)->with('images')->get();
        return $this->returnData('prods', $prods);
    }
    public function getProductById($id)
    {
        $product =  Product::where('id', $id)->with('images','category')->first();
        info($product);
        return $this->returnData(
            'product',
            $product
        );
    }
}

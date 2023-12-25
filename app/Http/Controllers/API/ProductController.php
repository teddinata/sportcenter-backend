<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Helpers\ResponseFormatter;


class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        $paginate = $request->input('paginate');
        $id = $request->input('id');
        $name = $request->input('name');
        $stock = $request->input('stock');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        $category = $request->input('category');

        if ($id) {
            $product = Product::with('productCategory', 'galleries')->find($id);

            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Product data successfully retrieved'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Product not found',
                    404
                );
            }
        }

        $product = Product::with('productCategory', 'galleries');

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($stock) {
            $product->where('stock', '>=', $stock);
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        if ($category) {
            $product->where('product_category_id', '=', $category);
        }

        return ResponseFormatter::success(
            $product->paginate($paginate ?? 10),
            'Product data successfully retrieved'
        );
    }

    // function category
    public function category(Request $request)
    {
        $id = $request->input('id');
        $paginate = $request->input('paginate');
        $name = $request->input('name');

        if ($id) {
            $category = ProductCategory::with('products')->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Category data successfully retrieved'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Category not found',
                    404
                );
            }
        }

        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $category->paginate($paginate ?? 10),
            'Category data successfully retrieved'
        );
    }
}

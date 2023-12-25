<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $product = Product::all();

            return DataTables::of($product)
            ->addColumn('action', function($product) {
                // tailwind
                return '
                <a href="'.route('product.edit', $product->id).'" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <form action="'.route('product.destroy', $product->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch product categories from the database
        $categories = ProductCategory::all();
        // return view
        return view('pages.dashboard.product.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // store data
        Product::create($request->validated());

        // return with success message
        return redirect()->route('product.index')->with('success', 'Product category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // return view
        // dd($product);
        // dd(request()->route());
        return view('pages.dashboard.product.edit', [
            'product' => $product,
            'categories' => ProductCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // update data
        $product->update($request->validated());

        // return with success message
        return redirect()->route('product.index')->with('success', 'Product category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // delete data
        $product->delete();

        // return with success message
        return redirect()->route('product.index')->with('success', 'Product category deleted successfully');
    }
}

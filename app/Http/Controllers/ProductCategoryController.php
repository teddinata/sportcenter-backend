<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $productCategories = ProductCategory::all();

            return DataTables::of($productCategories)
            ->addColumn('action', function($productCategories) {
                // tailwind
                return '
                <a href="'.route('category.edit', $productCategories->id).'" class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Edit</a>
                <form action="'.route('category.destroy', $productCategories->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Delete</button>
                </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        // store data
        ProductCategory::create($request->validated());

        // return with success message
        return redirect()->route('category.index')->with('success', 'Product category created successfully');
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
    public function edit(ProductCategory $category)
    {
        // return view
        // dd($productCategory);
        // dd(request()->route());
        return view('pages.dashboard.category.edit', [
            'item' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        // update data
        $category->update($request->validated());

        // return with success message
        return redirect()->route('category.index')->with('success', 'Product category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        // delete data
        $category->delete();

        // return with success message
        return redirect()->route('category.index')->with('success', 'Product category deleted successfully');
    }
}

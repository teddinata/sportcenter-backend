<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Models\Product;
use App\Http\Requests\ProductGalleryRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $product = ProductGallery::all();

            return DataTables::of($product)
            ->addColumn('product_name', function ($productGallery) {
                return $productGallery->product->name;
            })
            ->addColumn('action', function($product) {
                return '
                <a href="'.route('product-gallery.edit', $product->id).'" class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Edit</a>
                <form action="'.route('product-gallery.destroy', $product->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Delete</button>
                </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('pages.dashboard.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // fetch product
        $products = Product::all();

        // return view
        return view('pages.dashboard.gallery.create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request)
    {
        // upload image
        $image = $request->file('url')->store('assets/product', 'public');

        // store data
        ProductGallery::create([
            'product_id' => $request->product_id,
            'url' => $image,
            'description' => $request->description,
        ]);

        // redirect
        return redirect()->route('product-gallery.index')->with('success', 'Image added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGallery $productGallery)
    {
        // fetch product
        $products = Product::all();
        // dd(request()->route());

        // return view
        return view('pages.dashboard.gallery.edit', [
            'productGallery' => $productGallery,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGalleryRequest $request, ProductGallery $productGallery)
    {
        // upload image
        $image = $request->file('url')->store('assets/product', 'public');

        // dd($request->all());
        // update data
        $productGallery->update([
            'product_id' => $request->product_id,
            'url' => $image,
            'description' => $request->description,
        ]);

        // redirect
        return redirect()->route('product-gallery.index')->with('success', 'Product Image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $productGallery)
    {
        // delete image
        Storage::disk('public')->delete($productGallery->url);

        // delete data
        $productGallery->delete();

        // redirect
        return redirect()->route('product-gallery.index')->with('success', 'Product Image deleted successfully');
    }
}

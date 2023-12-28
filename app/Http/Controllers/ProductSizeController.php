<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use App\Models\Size;


class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $productSizes = ProductSize::with('product', 'size', 'product.productCategory', 'product.galleries')->get();

            return DataTables::of($productSizes)
                ->addColumn('product_image', function ($productSize) {
                    return '<img src="'.($productSize->product->galleries->count() ? asset('storage/'.$productSize->product->galleries->first()->image) : 'https://via.placeholder.com/200').'" alt="" style="max-height: 80px;">';
                })
                ->addColumn('product_name', function ($productSize) {
                    return $productSize->product ? $productSize->product->name : 'N/A';
                })
                ->addColumn('size', function ($productSize) {
                    return $productSize->size ? $productSize->size->size : 'N/A';
                })
                ->addColumn('action', function ($productSize) {
                    return '
                        <a href="'.route('product_size.edit', $productSize->id).'" class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Edit</a>
                        <form action="'.route('product_size.destroy', $productSize->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.product-size.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.product-size.create', [
            'products' => Product::all(),
            'sizes' => Size::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'stock' => 'nullable|integer',
        ]);

        // Membuat atau mengambil record pivot jika sudah ada
        $productSize = ProductSize::firstOrNew([
            'product_id' => $request->input('product_id'),
            'size_id' => $request->input('size_id'),
        ]);

        // Mengatur nilai stock
        $productSize->stock = $request->input('stock', 0);

        // Menyimpan perubahan
        $productSize->save();

        return redirect()->route('product_size.index')->with('success', 'Product Size has been created successfully!');
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
    public function edit(string $id)
    {
        // dd($id);
        $productSize = ProductSize::findOrFail($id);

        return view('pages.dashboard.product-size.edit', [
            'item' => $productSize,
            'products' => Product::all(),
            'sizes' => Size::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'stock' => 'nullable|integer',
        ]);

        // Membuat atau mengambil record pivot jika sudah ada
        $productSize = ProductSize::firstOrNew([
            'product_id' => $request->input('product_id'),
            'size_id' => $request->input('size_id'),
        ]);

        // Mengatur nilai stock
        $productSize->stock = $request->input('stock', 0);

        // Menyimpan perubahan
        $productSize->save();

        return redirect()->route('product_size.index')->with('success', 'Product Size has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $productSize = ProductSize::findOrFail($id);

        $productSize->delete();

        return redirect()->route('product_size.index')->with('success', 'Product Size has been deleted successfully!');
    }
}

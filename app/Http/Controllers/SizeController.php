<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use Yajra\DataTables\Facades\DataTables;


class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $size = Size::all();

            return DataTables::of($size)
            ->addColumn('action', function($size) {
                return '
                <a href="'.route('size.edit', $size->id).'" class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Edit</a>
                <form action="'.route('size.destroy', $size->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Delete</button>
                </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('pages.dashboard.size.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.size.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'size' => 'required|string|max:255',
        ]);

        Size::create([
            'size' => $request->size,
        ]);

        return redirect()->route('size.index')->with('success', 'Size has been created successfully!');
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
        $size = Size::findOrFail($id);

        return view('pages.dashboard.size.edit', [
            'item' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'size' => 'required|string|max:255',
        ]);

        $size = Size::findOrFail($id);

        $size->update([
            'size' => $request->size,
        ]);

        return redirect()->route('size.index')->with('success', 'Size has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);

        $size = Size::findOrFail($id);

        $size->delete();

        return redirect()->route('size.index')->with('success', 'Size has been deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            $trx = Transaction::all();

            return DataTables::of($trx)
            // add column user.name
            ->addColumn('user.name', function($trx) {
                return $trx->user->name;
            })
            // product that has been purchased
            ->addColumn('product', function($trx) {
                $product = '';
                foreach($trx->details as $detail) {
                    $product .= $detail->product->name . ', ';
                }
                return $product;
            })
            ->addColumn('action', function($trx) {
                return '
                <a href="'.route('transactions.show', $trx->id).'" class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Edit</a>
                <form action="'.route('transactions.destroy', $trx->id).'" method="POST" class="inline-block" style="margin: 0; padding: 0;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold px-2 py-1 m-1 rounded-md select-none ease focus:outline-none focus:shadow-outline">Delete</button>
                </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trx = Transaction::with('details.product.sizes')->findOrFail($id);

        return view('pages.dashboard.transaction.show', [
            'transaction' => $trx
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Temukan transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Validasi input
        $request->validate([
            'status' => ['required', 'string', 'in:PENDING,SUCCESS,FAILED'],
        ]);

        // Perbarui status transaksi
        $transaction->update([
            'status' => $request->status,
        ]);

        // Redirect kembali ke halaman rincian transaksi dengan pesan sukses
        return redirect()->route('transactions.show', $transaction->id)->with('success', 'Transaction status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

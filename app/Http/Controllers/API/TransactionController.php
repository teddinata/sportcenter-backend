<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Helpers\ResponseFormatter;
use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\ProductSize;
use Exception;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // index
    public function index(Request $request)
    {
        $paginate = $request->input('paginate');
        $id = $request->input('id');
        $status = $request->input('status');
        $user_id = $request->input('user_id');

        if ($id) {
            $transaction = Transaction::with('user', 'details.product')->find($id);

            if ($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Transaction data successfully retrieved'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Transaction not found',
                    404
                );
            }
        }

        $transaction = Transaction::with('user', 'details.product');

        if ($status) {
            $transaction->where('status', $status);
        }

        if ($user_id) {
            $transaction->where('user_id', $user_id);
        }

        return ResponseFormatter::success(
            $transaction->paginate($paginate),
            'Transaction data successfully retrieved'
        );
    }

    // checkout
    public function checkout(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'items' => ['required', 'array'],
                'items.*.id' => ['required', 'exists:products,id'],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
                'items.*.price' => ['nullable', 'integer'],
                // set product size id
                'items.*.size_id' => ['required', 'exists:sizes,id'],
                'total_price' => ['required', 'integer'],
                'shipping_price' => ['required', 'integer'],
                'status' => ['required', 'string', 'in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED'],
                'address' => ['nullable', 'string'],
                'notes' => ['nullable', 'string'],
            ]);

            // Get the user
            $user = Auth::user();

            // Creating a transaction
            $transaction = Transaction::create([
                'users_id' => $user->id,
                'invoice_code' => 'SPORT-' . date('dmy') . '-' . substr(uniqid(), 7, 6),
                'unique_code' => mt_rand(000, 999),
                'address' => $request->address,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'shipping_price' => $request->shipping_price,
                'total_price' => $request->total_price,
                'status' => 'PENDING',
            ]);

            foreach ($request->items as $product) {
                // find product
                $products = Product::find($product['id']);

                // check size and stock
                $size = ProductSize::where('product_id', $products->id)
                    ->where('size_id', $product['size_id'])
                    ->first();

                if (!$size) {
                    // Handle error jika ukuran tidak tersedia
                    return response()->json(['message' => 'Invalid size for product.'], 422);
                }
                TransactionDetail::create([
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'size_id' => $product['size_id'],
                    'quantity' => $product['quantity'],
                    'subtotal' => $product['quantity'] * $product['price'],
                ]);
            }

            // Returning the data to the client
            return ResponseFormatter::success($transaction->load('details.product.sizes'), 'Transaction success');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Transaction failed');
        }
    }
}

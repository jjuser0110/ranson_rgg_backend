<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transaction = Transaction::orderBy('datetime', 'DESC')->orderBy('id', 'DESC')->get();
        $product_variant = ProductVariant::all();
        $users = User::whereNotNull('userid')->get();

        return view('transaction.index')->with('transaction',$transaction)->with('product_variant',$product_variant)->with('users', $users);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $transaction=Transaction::create($request->all());

        if (isset($request->file_attachment)) {
            $upload = $this->upload($request->file_attachment, 'transaction', $transaction->id);
            $transaction->update([
                'bank_receipt' => $upload['file_path']
            ]);
        }

        return redirect()->route('transaction.index');
    }

    public function view(Transaction $transaction)
    {

        return view('transaction.view', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transaction.index');
    }

}

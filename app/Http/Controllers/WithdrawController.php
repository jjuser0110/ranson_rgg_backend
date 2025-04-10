<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::all();
        $users = User::whereNotNull('userid')->get();

        return view('withdraw.index', compact('withdraws', 'users'));
    }

    public function store(Request $request)
    {
        if ($request->withdraw_id > 0) {
            $withdraw = Withdraw::find($request->withdraw_id);
            $withdraw->update($request->all());
        } else {
            $withdraw = Withdraw::create($request->all());
        }

        if (isset($request->file_attachment)) {
            $upload = $this->upload($request->file_attachment, 'withdraw', $withdraw->id);
            $withdraw->update([
                'receipt' => $upload['file_path']
            ]);
        }

        return redirect()->route('withdraw.index')->withSuccess('Data saved');
    }

    public function view(Withdraw $withdraw)
    {
        return view('withdraw.view', compact('withdraw'));
    }

    public function destroy(Withdraw $withdraw)
    {
        $withdraw->delete();
        return redirect()->route('withdraw.index');
    }
}

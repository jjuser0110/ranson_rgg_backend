<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull('userid')->get();

        return view('user.index')->with('users',$users);
    }

    public function store(Request $request)
    {
        if($request->user_id>0){
            // dd($request->all());
            $user=User::find($request->user_id);
            $user->update([
                'email'=>$request->email,
                'username'=>$request->username,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator);
            }
            // dd($request->all());
            $request->merge(['password'=>Hash::make($request->password)]);
            //dd($request->all());
            $user=User::create($request->all());
        }

        return redirect()->back();
    }

    public function view(User $user)
    {
        $bank = Bank::all();
        $count = 0;
        $cost = 0;
        $approve_count=0;
        $approve_cost=0;
        if($user->downline->count()>0){
            foreach($user->downline as $row){
                if($row->downline->count()>0){
                    foreach($row->downline as $row1){
                        $count+=$row1->cards->count();
                        $approve_count+=$row1->cards->where('is_approved',1)->count();
                        $cost+=$row1->cards->sum('cost');
                        $approve_cost+=$row1->cards->where('is_approved',1)->sum('cost');
                    }
                }

                $count+=$row->cards->count();
                $approve_count+=$row->cards->where('is_approved',1)->count();
                $cost+=$row->cards->sum('cost');
                $approve_cost+=$row->cards->where('is_approved',1)->sum('cost');
            }
        }
        $count+=$user->cards->count();
        $approve_count+=$user->cards->where('is_approved',1)->count();
        $cost+=$user->cards->sum('cost');
        $approve_cost+=$user->cards->where('is_approved',1)->sum('cost');

        return view('user.view')->with('user',$user)->with('bank',$bank)->with('count',$count)->with('cost',$cost)->with('approve_count',$approve_count)->with('approve_cost',$approve_cost);
    }

    public function resetPassword(User $user)
    {
        $user->update(['password'=>Hash::make('123456789')]);

        return redirect()->back();
    }


    public function setInactive(User $user)
    {
        $user->update(['is_active'=>0]);

        return redirect()->back();
    }

    public function setActive(User $user)
    {
        $user->update(['is_active'=>1]);

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->withSuccess('Password Changed!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $agent = User::where('role','Agent')->get();
        
        return view('agent.index')->with('agent',$agent);
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator);
        }
        if($request->agent_id>0){
            
            // dd($request->all());
            $agent=User::find($request->agent_id);
            $agent->update(['name'=>$request->name,'username'=>$request->username]);
        }else{
            $request->merge(['password'=>Hash::make('123456789'),'role'=>'Agent']);
            $agent=User::create($request->all());  
        }  
        
        return redirect()->route('agent.index');
    }

    public function reset_password(User $agent)
    {
        $agent->update(['password'=>Hash::make('123456789')]);
        return redirect()->route('agent.index')->withSuccess('Password Reset Done');
    }
   
}

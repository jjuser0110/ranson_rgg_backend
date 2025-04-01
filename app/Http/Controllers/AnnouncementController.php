<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcement = Announcement::all();
        
        return view('announcement.index')->with('announcement',$announcement);
    }

    public function store(Request $request)
    {
        if($request->announcement_id>0){
            $announcement=Announcement::find($request->announcement_id);
            $announcement->update($request->all());
        }else{
            Announcement::query()->update(['is_active'=>null]);
            $request->merge(['is_active'=>1]);
            $announcement=Announcement::create($request->all());  
        }  
        
        return redirect()->route('announcement.index');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcement.index');

    }

    public function setActive(Announcement $announcement)
    {
        Announcement::query()->update(['is_active'=>null]);
        $announcement->update(['is_active'=>1]);
        return redirect()->route('announcement.index');

    }

    public function setInActive(Announcement $announcement)
    {
        $announcement->update(['is_active'=>null]);
        return redirect()->route('announcement.index');

    }
   
}

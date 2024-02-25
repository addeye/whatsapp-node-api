<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('pages.setting.index', [
            'data' => Setting::find(1),
        ]);
    }

    public function save(Request $request){

        $setting = Setting::find(1);
        $setting->update($request->all());
        return redirect('/setting')->with('success', 'Setting Saved');
    }
}

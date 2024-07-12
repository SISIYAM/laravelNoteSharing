<?php

namespace App\Http\Controllers;

use App\Models\Universitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    // load admin dashboard
    public function loadDashboard(){
        return view('admin.dashboard');
    }

    // load universities page
    public function loadUniversities(){
        $data = ['h','f','e','r',''];
        return view('admin.list',['thead' => $data]);
    }

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'string|required|min:2',
            'image' => 'mimes:png,jpg,jpeg,webp|max:3000',
        ]);
        $path = $req->file('image')->store('image','public');

        $insert = Universitie::create([
            'name' => $req->name,
            'image' => $path,
            'author' => Auth::user()->name,
        ]);

        return redirect()->route('admin.manage.universities')->with('success',"University added successfully!");

    }
}
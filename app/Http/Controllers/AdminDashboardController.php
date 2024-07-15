<?php

namespace App\Http\Controllers;

use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{

    // methods for load views


    // load admin dashboard
    public function loadDashboard(){
        return view('admin.dashboard');
    }

    // load universities page
    public function loadUniversities(){
        $data = ['No','Name','Semesters','Author','Status',''];

        $universities = Universitie::all();

        return view('admin.list',['key' => 'university','thead' => $data,'tableRow' => $universities]);
    }

    // load semesters page
    public function loadSemester(){
        $data = ['No','University','Semester','Author','Status',''];

        $semester = Semister::with('university')->get();

        // return $semester;
        return view('admin.list',['key' => 'semester', 'thead' => $data, 'tableRow' => $semester]);
    }

    // load materials form
    public function loadMaterialsForm(){
        return view('admin.layouts.common-form');
    }


    // methods for query

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'string|required|min:2',
            'semester' => 'integer|required|min:1|max_digits:2',
            'image' => 'mimes:png,jpg,jpeg,webp|max:3000',
        ]);

        // Handle the image upload
        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('images', 'public');
        } else {
            $path = 'imgae/default_image.jpg'; // This will never be reached because 'image' is required
        }

        // admin name
        $admin = Auth::user()->name;
        $insert = Universitie::create([
            'name' => $req->name,
            'semester' => $req->semester,
            'image' => $path,
            'author' => $admin,
        ]);

         // Retrieve the ID of the recently created university
         $universityId = $insert->id;

        // $output = [];

        if($insert){
            for ($i=0; $i < $req->semester; $i++) {
                $semesterInsert = Semister::create([
                    'university_id' => $universityId,
                    'semister_name' => 'Semester '.$i+1,
                    'author' => $admin,
                ]);
                // $output[] = $semesterInsert;
            }
        }

        return redirect()->route('admin.manage.universities')->with(['success' => 'University added successfully!']);
        // return $output;
        // return response()->json(['success' => true, 'data' => $insert]);

    }

    // add materials
    public function addMaterials(){

    }
}
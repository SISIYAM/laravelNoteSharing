<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Material;
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
        // get university name
        $university = Universitie::where('status',1)->get();
        return view('admin.forms.add-materials-form',['universities' => $university]);

    }

    // search semester using ajax
    public function universitySemester(Request $req){

        $searchSemester = Semister::where('university_id', $req->id)->get();

        return response()->json($searchSemester);
    }

    // load materials
    public function loadMaterials(){
        $data = ['No','University','Semester','Title','Author','Status',''];

        $materials = Material::with('getUniversity','getSemester')->get();
        return view('admin.list',['key' => 'materials','thead' => $data,'tableRow' => $materials]);
    }

    // load university form

    public function loadUniversityForm(){
        return view('admin.forms.add-university-form');
    }

    // methods for query

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'string|required|min:2',
            'semester' => 'integer|required|min:1|max_digits:2',
            'description' => 'required|string',
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
            'description' => $req->description,
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

        return redirect()->route('admin.add.universities')->with(['success' => 'University added successfully!']);
        // return $output;
        // return response()->json(['success' => true, 'data' => $insert]);

    }

    // add materials
    public function addMaterials(Request $req){
        $admin = Auth::user()->name;
        $req->validate([
            'university_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required | string',
            'pdfs' => 'required|array', // Validate that 'pdfs' is an array
            'pdfs.*' => 'file|mimes:pdf', // Validate each file in the 'pdfs' array
            // Add more validation rules for pdfs array if necessary
        ]);

        $insert = Material::create([
            'university_id' => $req->university_id,
            'semester_id' => $req->semester_id,
            'title' => $req->title,
            'description' => $req->description,
            'author' => $admin,
        ]);


        // Handle the file uploads
        if ($req->hasFile('pdfs')) {
            foreach ($req->file('pdfs') as $file) {
                $path = $file->store('pdfs', 'public');

                $insertPdf = Pdf::create([
                    'material_id' => $insert->id,
                    'pdf' => $path,
                ]);
            }
        }

        // return $insert;


        // $material = new Material();
        // $material->university_id = $req->university_id;
        // $material->semester_id = $req->semester_id;
        // $material->title = $req->title;
        // $material->author = $admin;
        // $material->pdf = json_encode($paths);

        // $material->save();

        return redirect()->route('admin.form.materials')->with('success','Materials Added Successfully!');
        // return response()->json($material);
        // return $req->all();
    }


}
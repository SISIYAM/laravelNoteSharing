<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Facultie;
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

        $materials = Material::with('getUniversity','getSemester','getAuthor')->get();
        // return $materials;
        return view('admin.list',['key' => 'materials','thead' => $data,'tableRow' => $materials]);
    }

    // load university form
    public function loadUniversityForm(){
        return view('admin.forms.add-university-form');
    }

    // load update materials form
    public function loadMaterialsUpdateForm(string $slug = null){

        // fetch materials data
        $data = Material::where('slug',$slug)->with('getUniversity','getSemester','getPdf')->first();

        // fetch universities
        $universities = Universitie::all();

        if($data){
            $university_id = $data->university_id;
        }else{
            $university_id = null;
        }
        // fetch semesters
        $semesters = Semister::where('university_id',$university_id)->get();

        // return $data;

        return view('admin.forms.update-materials-form',['data' => $data,'universities' => $universities,'semesters' => $semesters]);
    }

    // load faculties list
    public function loadFaculties(){
        $thead = ['No','Name','Post','Author','Status',''];

        $data = Facultie::all();

        return view('admin.list',['key' => 'faculties', 'thead' => $thead,'tableRow' => $data]);
        // return $data;
    }

    // load add faculties form
    public function loadFacultiesForm(){
        return view('admin.forms.add-faculties-form');
    }

    // load faculties update form
    public function loadFacultiesUpdateForm(string $slug = null){
        $data = Facultie::where('slug',$slug)->first();
        // return $data;
        return view('admin.forms.update-faculty-from',['data' => $data]);
    }

    // load pdf info for modal using ajax
    public function loadPdfInfo(Request $req){
        $data = Pdf::where('id',$req->id)->first();
        return $data;
    }

    // method for load university update form
    public function loadUpdateUniversityForm(String $slug){
        $university = Universitie::where(compact('slug'))->with('semisters')->first();
        return view('admin.forms.update-university-form',['data' => $university]);
    }


    // methods for query

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'alpha|required|min:2',
            'semester' => 'required|numeric|min:1|max_digits:2',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:3000',
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
                    'status' => 1,
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
        $admin = Auth::user()->id;
        $req->validate([
            'university_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdfs' => 'array', // Validate that 'pdfs' is an array
            'pdfs.*' => 'file|mimes:pdf', // Validate each file in the 'pdfs' array
            'titlesPdf' => 'array',
            'titlesPdf.*' => 'nullable|string',
            'titlesDrive' => 'array',
            'titlesDrive.*' => 'nullable|string',
            'links' => 'array',
            'links.*' => 'nullable|url',

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
            foreach ($req->file('pdfs') as $i => $file) {
                $path = $file->store('pdfs', 'public');
                if($req->titlesPdf[$i] != NULL){
                    $title = $req->titlesPdf[$i];
                }else{
                    $title = 'Pdf '.$i+1;
                }
                $insertPdf = Pdf::create([
                    'material_id' => $insert->id,
                    'title' => $title,
                    'pdf' => $path,
                    'type' => 1,            // if type 1 then pdf
                    'author' => $admin,
                ]);
            }
        }

        // if google drive link upload
            foreach($req->links as $j=> $link){
                if($link != NULL){
                    if($req->titlesDrive[$j] != NULL){
                        $title = $req->titlesDrive[$j];
                    }else{
                        $title = 'Pdf '.$j+1;
                    }
                    $insertDrive = Pdf::create([
                        'material_id' => $insert->id,
                        'title' => $title,
                        'pdf' => $link,
                        'type' => 2,      // if type 2 then google drive
                        'author' => $admin,
                    ]);
                }
            }

        return redirect()->route('admin.form.materials')->with('success','Materials Added Successfully!');
    }

    // function for add faculties
    public function addFaculties(Request $req){

        // validation
        $req->validate([
            'name' => 'required|string|max:255',
            'resignation' => 'required|string|max:255',
            'degree' => 'string|nullable',
            'email' => 'email|nullable',
            'mobile' => 'nullable|numeric',
            'image' => 'nullable|mimes:jpg,png,jpeg,webp',
        ]);

        if($req->hasFile('image')){
            $path = $req->file('image')->store('images/faculty','public');
        }else{
            $path = "images/faculty/defaultFaculty.png";
        }

        $insert = Facultie::create([
            'name' => $req->name,
            'email' => $req->email,
            'mobile' => $req->mobile,
            'description' => $req->description,
            'image' => $path,
            'degree' => $req->degree,
            'post' => $req->resignation,
            'author' => Auth::user()->name,
        ]);

        return redirect()->route('admin.form.faculties')->with('success','Added successfully!');
        // return ['filePath' => $path, 'request' => $req->all(),'Author' => Auth::user()];
        // return $insert;
    }




}
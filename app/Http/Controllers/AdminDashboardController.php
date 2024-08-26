<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Pdf;
use App\Models\Review;
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

    // load universities list
    public function loadUniversities(){
        $data = ['No','Name','Departments','Materials & Pdfs','Author','Status',''];

        $universities = Universitie::with('material.getPdf')->get();
        // return $universities;

        return view('admin.list',['key' => 'university','thead' => $data,'tableRow' => $universities]);
    }

    // load departments list
    public function loadDepartments() {
        $thead = ['No','Department', 'University','Semesters','Materials','Author','Status',''];
        
        $departments = Department::with('getUniversity','getSemesters.materials.getPdf')->get();
        // return $departments;
        return view('admin.list',['key' => 'departments','thead' => $thead,'tableRow' => $departments]);
    }

    // load materials form
    public function loadMaterialsForm(){
        // get university name
        $university = Universitie::where('status',1)->get();
        return view('admin.forms.add-materials-form',['universities' => $university]);

    }

    // search department using ajax
    public function universityDepartment(Request $req){

        $searchDepartment = Department::where('university_id',$req->id)->get();
        
        $availableSemester = [];
        foreach($searchDepartment as $department){
            $searchSem = Semister::where('department_id', $department->id)->get();
            
            if($searchSem->count() != null){
                array_push($availableSemester,$searchSem);
            }
        }


        return response()->json(['departments'=> $searchDepartment, 'availableSemesters' => $availableSemester]);
    }

    // search semester using ajax
    public function departmentSemester(Request $req){

        $searchSemester = Semister::where('department_id', $req->id)->get();


        return response()->json($searchSemester);
    }

    // load materials list
    public function loadMaterials(){
        $data = ['No','Title','Pdfs','University','Department','Semester','Author','Status',''];

        $materials = Material::with('getUniversity','getSemester.getDepartment','getPdf','getAuthor')->get();
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
        $data = Material::where('slug',$slug)->with('getUniversity','getSemester.getDepartment','getPdf')->first();
        
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
    public function loadUpdateUniversityForm(String $slug = null){
        $university = Universitie::where(compact('slug'))->with('getDepartments.getSemesters','semisters.materials')->first();
        return view('admin.forms.update-university-form',['data' => $university]);
        // return $university;
    }

    // load department update form
    public function loadUpdateDepartmentForm(string $slug = null) {
        $department = Department::where(compact('slug'))->with('getUniversity','getSemesters')->first();

        $universities = Universitie::all();
        return view('admin.forms.update-department-form',['data' => $department,'universities' => $universities]);
     }

    // method for load not assigned materials
    public function loadNotAssignedMaterials(Request $req){
        $materials = Material::where('allocated', 0)
                     ->where('status', 1)
                     ->with('getPdf')
                     ->get();
        $existsMaterials = Material::where('semester_id',$req->semester_id)
                        ->with('getPdf')         
                        ->get();
        return response()->json([
            'success' => true,
            'notAllocatedMaterials' => $materials,
            'existMaterials' => $existsMaterials,
        ]);
    }

      // method for load not assigned pdfs
      public function loadNotAssignedPdfs(Request $req){
        $pdfs = Pdf::where('material_id', null)
                     ->get();
        $existsPdfs = Pdf::where('material_id',$req->material_id)       
                        ->get();
        return response()->json([
            'success' => true,
            'notAllocatedPdfs' => $pdfs,
            'existPdfs' => $existsPdfs,
        ]);
    }

    // method for load pdfs list
    public function loadPdfs(){

        $thead = ['No','Material','Title', 'Type','Author', ''];

        $getPdfs = Pdf::with('getMaterial','getAuthor')->get();

        return view('admin.list',['key' => 'pdfs', 'thead' => $thead, 'tableRow' => $getPdfs]);
    }
    
   


    // methods for query

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'alpha|required|min:2',
            'semester' => 'required|numeric|min:1|max_digits:2',
            'description' => 'required|string',
            'image' => 'mimes:png,jpg,jpeg,webp|max:3000',
        ]);

        // Handle the image upload
        if ($req->hasFile('image')) {
            $path = $req->file('image')->store('images', 'public');
        } else {
            $path = 'images/default-image.jpg'; 
        }

        // admin name
        $admin = Auth::user()->id;
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
            'university_id' => 'numeric|nullable',
            'semester_id' => 'numeric|nullable',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdfs' => 'array', // Validate that 'pdfs' is an array
            'pdfs.*' => 'file|mimes:pdf', // Validate each file in the 'pdfs' array
            'titlesPdf' => 'array',
            'titlesPdf.*' => 'nullable|string',
            'titlesDrive' => 'array',
            'titlesDrive.*' => 'nullable|string',
            'links' => 'array',
            'links.*' => [
            'nullable',
            'url',
            function ($attribute, $value, $fail) {
                if (!preg_match('/^(https:\/\/)?(drive\.google\.com\/)/', $value)) {
                    $fail('The '.$attribute.' must be a valid Google Drive link.');
                }
            },
        ],

        ]);

        $insert = Material::create([
            'university_id' => $req->university_id,
            'semester_id' => $req->semester_id,
            'title' => $req->title,
            'description' => $req->description,
            'status' => 1,
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

    // method for load reviews
    public function loadReviews(){

        // table headers
        $thead = ['No','Time','Rating','Name','Review','Pdf',''];

        $reviews = Review::orderBy('id','DESC')->get();
        return view('admin.list',['key' => 'reviews','thead' => $thead, 'tableRow' => $reviews]);
    }


}
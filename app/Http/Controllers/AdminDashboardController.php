<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\User;
use App\Models\Review;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
use App\Models\AssignUser;
use App\Models\Department;
use App\Models\Universitie;
use Illuminate\Http\Request;
use App\Models\MaterialRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminDashboardController extends Controller
{
   
    // Method to fetch assigned department IDs for the logged-in user
    protected function getAssignedDepartmentIds()
    {
        $user_id = Auth::user()->id;
        return AssignUser::where('user_id', $user_id)->pluck('department_id');
    }

    // methods for load views


    // load admin dashboard
    public function loadDashboard(){

        if (Gate::any(['isAdmin', 'isModarator'])) {
            return view('admin.dashboard');
        } else {
            return redirect()->route('error.403');
        }
        
    }

    // load universities list
    public function loadUniversities(){

        // check if logged in user admin or not
        if(Gate::allows('isAdmin')){
            $data = ['No','Name','Departments','Materials & Pdfs','Author','Status',''];

            $universities = Universitie::with('material.getPdf')->get();
            // return $universities;
    
            return view('admin.list',['key' => 'university','thead' => $data,'tableRow' => $universities]);
        }else{
            return redirect()->route('error.403');
        }
        
    }

    // load departments list
    public function loadDepartments() {

      $thead = ['No','Department', 'University','Semesters','Materials','Author','Status',''];   
        if(Gate::allows('isAdmin')){ 
            $departments = Department::with('getUniversity','getSemesters.materials.getPdf')->get();
            // return $departments;
            return view('admin.list',['key' => 'departments','thead' => $thead,'tableRow' => $departments]);

        }elseif (Gate::allows('isModarator')) {
            // moderator can view assigned departments

            // fetch assigned department IDs for the user
            $assignedDeptIds = $this->getAssignedDepartmentIds();
            
            // fetch departments based on the assigned IDs
            $departments = Department::with('getUniversity', 'getSemesters.materials.getPdf')
                ->whereIn('id', $assignedDeptIds)
                ->get();

            return view('admin.list', ['key' => 'departments', 'thead' => $thead, 'tableRow' => $departments]);
        }else{
            return redirect()->route('error.403');
        }
    }

    // load materials form
    public function loadMaterialsForm(){
        // get university name

        // if admin
        if(Gate::allows('isAdmin')){
            $university = Universitie::where('status',1)->get();
            return view('admin.forms.add-materials-form',['universities' => $university]);
        }elseif(Gate::allows('isModarator')){
         // moderator can view assigned departments

         // fetch assigned department IDs for the user
         $assignedDeptIds = $this->getAssignedDepartmentIds();
         
         // fetch universities ids based on the department IDs
         $findUniversitiesId = Department::whereIn('id',$assignedDeptIds)->pluck('university_id');
         // now find universities based on assigned department
         $university = Universitie::where('status',1)->whereIn('id',$findUniversitiesId)->get();
         return view('admin.forms.add-materials-form',['universities' => $university]);

        }else{
            return redirect()->route('error.403');
        }
    }

    // search department using ajax
    public function universityDepartment(Request $req){

    // if admin
    if(Gate::allows('isAdmin')){
        $searchDepartment = Department::where('university_id',$req->id)->get();     
    }elseif(Gate::allows('isModarator')){
         // moderator can view assigned departments

         // fetch assigned department IDs for the user
         $assignedDeptIds = $this->getAssignedDepartmentIds();   
         // fetch departments based on the assigned IDs
         $searchDepartment = Department::where('university_id',$req->id)->whereIn('id',$assignedDeptIds)->get();
    }
        $availableSemester = [];
        if ($searchDepartment->isNotEmpty()) {
  
            $firstDepartment = $searchDepartment->first();
            $searchSem = Semister::where('department_id', $firstDepartment->id)->get();
            if ($searchSem->isNotEmpty()) {
                $availableSemester = $searchSem;
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
        
        //if admin
        if(Gate::allows('isAdmin')){
            $materials = Material::with('getUniversity','getSemester.getDepartment','getPdf','getAuthor')->get();
            return view('admin.list',['key' => 'materials','thead' => $data,'tableRow' => $materials]);
        }elseif (Gate::allows('isModarator')) {

        // moderator can view assigned departments

        // fetch assigned department IDs for the user
        $assignedDeptIds = $this->getAssignedDepartmentIds();
        
        // fetch department based semesters and user id
        $findSemestersId = Semister::whereIn('department_id',$assignedDeptIds)->pluck('id');
        
        // now find materials based on this semesters Ids
        $materials = Material::with('getUniversity','getSemester.getDepartment','getPdf','getAuthor')->whereIn('semester_id',$findSemestersId)
                                                    ->orWhere('author',Auth::user()->id)
                                                    ->get();
        return view('admin.list',['key' => 'materials','thead' => $data,'tableRow' => $materials]);

        }else{
            return redirect()->route('error.403');
        }
        
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
        if(Gate::allows('isAdmin')){
        
        $data = Facultie::all();
        return view('admin.list',['key' => 'faculties', 'thead' => $thead,'tableRow' => $data]);
        
        }else{
            return redirect()->route('error.403');
        }
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
        // if admin
        if(Gate::allows('isAdmin')){
            $department = Department::where(compact('slug'))->with('getUniversity','getSemesters')->first();

            $universities = Universitie::all();
            return view('admin.forms.update-department-form',['data' => $department,'universities' => $universities]);
        }elseif(Gate::allows('isModarator')){
            // if modarator

            $assignedDeptIds = $this->getAssignedDepartmentIds();
            // search universities id based on departments
            $findUniversitiesId = Department::whereIn('id',$assignedDeptIds)->pluck('university_id');
            
            $department = Department::where(compact('slug'))->with('getUniversity','getSemesters')->first();

            $universities = Universitie::whereIn('id',$findUniversitiesId)->get();
            return view('admin.forms.update-department-form',['data' => $department,'universities' => $universities]);
        }
     }

    // method for load not assigned materials
    public function loadNotAssignedMaterials(Request $req){
        //if admin
        if(Gate::allows('isAdmin')){
            $materials = Material::where('allocated', 0)
                     ->where('status', 1)
                     ->with('getPdf')
                     ->get();
        $existsMaterials = Material::where('semester_id',$req->semester_id)
                        ->with('getPdf')         
                        ->get();
        }elseif(Gate::allows('isModarator')){
        // materials based on user id
        $materials = Material::where('allocated', 0)
                     ->where('status', 1)
                     ->where('author',Auth::user()->id)
                     ->with('getPdf')
                     ->get();
        $existsMaterials = Material::where('semester_id',$req->semester_id)
                        ->with('getPdf')         
                        ->get();
        }
        return response()->json([
            'success' => true,
            'notAllocatedMaterials' => $materials,
            'existMaterials' => $existsMaterials,
        ]);
    }

      // method for load not assigned pdfs
      public function loadNotAssignedPdfs(Request $req){
        // if admin
        if(Gate::allows('isAdmin')){
            $pdfs = Pdf::where('material_id', null)
            ->get();
            $existsPdfs = Pdf::where('material_id',$req->material_id)       
               ->get();
        }elseif(Gate::allows('isModarator')){
            $pdfs = Pdf::where('material_id', null)
            ->where('author',Auth::user()->id)
            ->get();
            $existsPdfs = Pdf::where('material_id',$req->material_id)       
               ->get();
        }
       
        return response()->json([
            'success' => true,
            'notAllocatedPdfs' => $pdfs,
            'existPdfs' => $existsPdfs,
        ]);
    }

    // method for load pdfs list
    public function loadPdfs(){

        $thead = ['No','Title','Material','Department', 'Type','Author', ''];

        // if admin
        if(Gate::allows('isAdmin')){
            $getPdfs = Pdf::with('getMaterial.getSemester.getDepartment','getAuthor')->get();

            return view('admin.list',['key' => 'pdfs', 'thead' => $thead, 'tableRow' => $getPdfs]);
        
        }elseif(Gate::allows('isModarator')){
            // moderator can view assigned departments
 

            // fetch assigned department IDs for the user
            $assignedDeptIds = $this->getAssignedDepartmentIds();

            // fetch department based semesters
            $findSemestersId = Semister::whereIn('department_id',$assignedDeptIds)->pluck('id');
            
            // fetch materials based on semester ids
            $findMaterialsId = Material::whereIn('semester_id',$findSemestersId)->pluck('id');
            
            $getPdfs = Pdf::with('getMaterial.getSemester.getDepartment','getAuthor')
                                    ->whereIn('material_id',$findMaterialsId)
                                    ->orWhere('author',Auth::user()->id)
                                    ->get();
           
            return view('admin.list',['key' => 'pdfs', 'thead' => $thead, 'tableRow' => $getPdfs]);
        }else{
            return redirect()->route('error.403');  
        }

        
    }
    
    // method for load admins list
    public function loadAdminsPage(){
        $thead = ['No','Name','Email','Role','Assigned Departments','Status','Last Login',''];
        
        $users = User::with('getAssigned')->get();
        
        return view('admin.list',['key'=>'users','thead' => $thead, 'tableRow' => $users]);
    }

    // load departments for assign
    public function loadFilterUniversity(Request $req){
        // search in assign table 
        $findAssignedDepartment = AssignUser::where('user_id',$req->user_id)
                                    ->with('getDepartment')                                        
                                    ->get();

        $universities = Universitie::with('getDepartments')->get();
        // Retrieve assigned department IDs for the user
        $AssignDepartmentIds = AssignUser::where('user_id', $req->user_id)->pluck('department_id');

        // fetch universities with filtered departments
        $universities = Universitie::with(['getDepartments' => function ($query) use ($AssignDepartmentIds) {
            if ($AssignDepartmentIds->isNotEmpty()) {
                // If the user has assigned departments
                $query->whereNotIn('id', $AssignDepartmentIds);
            }
        }])->get();
        return response()->json(['status' => true, 'universities' => $universities,'assignedDepartments' => $findAssignedDepartment]);
    }

    // method for filter departments according to university
    public function filterUniversityDepartment(Request $req){

        // Retrieve assigned department IDs for the user
        $AssignDepartmentIds = AssignUser::where('user_id',$req->user_id)->pluck('department_id');

        if ($AssignDepartmentIds->isEmpty()) {
            $findDept = Department::where('university_id', $req->university_id)->get();
        } else {
            $findDept = Department::where('university_id', $req->university_id)
                                  ->whereNotIn('id', $AssignDepartmentIds)
                                  ->get();
        }

        return response()->json(['status' => true, 'departments' => $findDept]);
    }

    // method for load materials request
    public function loadMaterialsRequest(){

        $thead = ['No','Name','Department','Batch','Roll','Request','Time'];

        $materialRequest = MaterialRequest::orderBy('id', 'desc')->get();
        // return $materialRequest;
        return view('admin.list',['key' => 'materialRequest','thead' => $thead,'tableRow' => $materialRequest]);


    }
   

    // methods for query

    // add university
    public function addUniversity(Request $req){
        $req->validate([
            'name' => 'alpha|required|min:2',
            'description' => 'nullable|string',
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
                // Pattern for Google Drive file or folder links
                if (!preg_match('/^(https:\/\/)?(drive\.google\.com\/(file\/d\/|drive\/folders\/|open\?id=))/', $value)) {
                    $fail('The ' . $attribute . ' must be a valid Google Drive link.');
                }
               },
             ],


        ]);

        // Check material allocation 
        $allocate = 0;
        $universityId = NULL;
        $semesterID = NULL;
        if($req->semester_id != NULL && $req->university_id != NULL){
            $allocate = 1;
            $universityId = $req->university_id;
            $semesterID = $req->semester_id;
        }

        $insert = Material::create([
            'university_id' => $universityId,
            'semester_id' => $semesterID,
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
        $thead = ['No','Pdf','Material','Time','Rating','Name','Dept','Batch','Review',''];

        // if admin
        if(Gate::allows('isAdmin')){
            $reviews = Review::orderBy('id','DESC')->get();
            return view('admin.list',['key' => 'reviews','thead' => $thead, 'tableRow' => $reviews]);
        }elseif(Gate::allows('isModarator')){
            // assigned departments
            $assignedDeptIds = $this->getAssignedDepartmentIds();
            
            // find assigned semesters based on department
            $assignedSemestersId = Semister::whereIn('department_id',$assignedDeptIds)->pluck('id');

            // find assigned material id
            $assignedMaterialsId = Material::whereIn('semester_id',$assignedSemestersId)->pluck('id');
            
            // find assigned pdfs
            $findAssignedPdfsId = Pdf::whereIn('material_id',$assignedMaterialsId)->pluck('id');
            
            $reviews = Review::orderBy('id','DESC')
                                ->whereIn('pdf_id',$findAssignedPdfsId)
                                ->with('getPdf.getMaterial')
                                ->get();
            return view('admin.list',['key' => 'reviews','thead' => $thead, 'tableRow' => $reviews]);
        }else{
            return redirect()->route('error.403');            
        }
        
    }


}
<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
use App\Models\AssignUser;
use App\Models\Department;
use App\Models\Universitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AdminUpdateController extends Controller
{

    // Method to fetch assigned department IDs for the logged-in user
    protected function getAssignedDepartmentIds()
    {
        $user_id = Auth::user()->id;
        return AssignUser::where('user_id', $user_id)->pluck('department_id');
    }


    // method for update pdf
    public function updatePdfAjax(Request $req){
        $admin = Auth::user()->id;


    $req->validate([
        'title' => 'nullable|string',
        'pdf' => 'nullable|file|mimes:pdf',
        'drive' => 'nullable|url',
    ]);


    $pdf = Pdf::findOrFail($req->pdf_id);


    if ($req->hasFile('pdf')) {

        if (Storage::disk('public')->exists($pdf->pdf)) {
            Storage::disk('public')->delete($pdf->pdf);
        }


        $path = $req->file('pdf')->store('pdfs', 'public');


        $pdf->update([
            'pdf' => $path,
            'type' => 1,     // if type 1 then pdf
            'title' => $req->title,
        ]);
    } else {
        if($req->drive != NULL){
            if (Storage::disk('public')->exists($pdf->pdf)) {
                Storage::disk('public')->delete($pdf->pdf);
            }
            $pdf->update([
                'title' => $req->title,
                'pdf' => $req->drive,
                'type' => 2,     // if type 2 then google drive
            ]);
        }else{
            // Update title if no new file is uploaded
            $pdf->update([
                'title' => $req->title,
            ]);
        }

    }

    $pdfAfter = Pdf::where('id',$req->pdf_id)->first();
    $MaterialPdf = Pdf::where('material_id',$req->material_id)->get();

    return ['success' => 'Update successfully!','pdf'=>$pdfAfter,'materialPdf' => $MaterialPdf];
    }

    // method for update material
    public function updateMaterials(Request $req, string $slug){
        $admin = Auth::user()->id;
        $req->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdfs' => 'array', // Validate that 'pdfs' is an array
            'pdfs.*' => 'file|nullable|mimes:pdf', // Validate each file in the 'pdfs' array
            'titlesPdf' => 'array',
            'titlesPdf.*' => 'nullable|string',
            'titlesDrive' => 'array',
            'titlesDrive.*' => 'nullable|string',
            'links' => 'array',
            'links.*' => 'nullable|url',
        ]);

        $material = Material::where(compact('slug'))->first();
        $material->update([
            'title' => $req->title,
            'description' => $req->description,
            'status' => $req->status,
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
                    'material_id' => $material->id,
                    'title' => $title,
                    'pdf' => $path,
                    'type' => 1,   // if type 1 then pdf
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
                        'material_id' => $material->id,
                        'title' => $title,
                        'pdf' => $link,
                        'type' => 2,    // if type 2 then google drive
                        'author' => $admin,
                    ]);
                }
            }

            return redirect()->route('admin.update.materials.form',$req->slug)->with('success','Materials Added Successfully!');
    }

    // method for update semester form using ajax
    public function updateSemesters(Request $req){
       $req->validate([
        'semester' => 'required|string',
       ]);
       $semester = Semister::findOrFail($req->id);
       $semester->update([
        'semister_name' => $req->semester,
       ]);

       return ['success' => $req->semester .' Updated Successfully!'];
    }

    // method for add new semester while updating university
    public function addNewSemester(Request $req){
        $admin = Auth::user()->id;
        $req->validate([
        'semesters' => 'array',
        'semesters.*' => 'nullable|string',
        ]);

        $output = [];
        foreach ($req->semesters as $semester) {
            if($semester != NULL){
                $insert = Semister::create([
                    'university_id' => $req->university_id,
                    'department_id' => $req->department_id,
                    'semister_name' => $semester,
                    'status' => 1,
                    'author' => $admin,
                ]);
                array_push($output,$insert);
            }
        }

        return response()->json(["success" => "true", "data" => $output]);
    }


    // method for update university
    public function updateUniversity(Request $req, string $slug){
        $admin = Auth::user()->id;

        $req->validate([
            'name' => 'alpha|required|min:2',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:3000',
            'status' => 'required|numeric',
        ]);

        $university = Universitie::where(compact('slug'))->first();
        $id = $university->id;
        $semesterCount = Semister::where('university_id',$id)->count();

          // Handle the image upload
          if ($req->hasFile('image')) {
            if (Storage::disk('public')->exists($university->image)) {
                Storage::disk('public')->delete($university->image);
            }
            $path = $req->file('image')->store('images', 'public');
        } else {
            $path = $university->image;
        }

        $university->update([
            'name' => $req->name,
            'semester' => $semesterCount,
            'description' => $req->description,
            'status' => $req->status,
            'image' => $path,
            'author' => $admin,
        ]);

        return redirect()->route('admin.form.update.university',$slug)->with('success',$req->name.' Updated Successfully!');
    }
    

    // update semester and assigned materials into it
    public function assignMaterials(Request $req) {
        
        if($req->assignedMaterials){
            foreach($req->assignedMaterials as $materialId) {
                $assign = Material::findOrFail($materialId);
                if ($assign) { 
                    $assign->update([
                        'university_id' => $req->university_id,
                        'semester_id' => $req->semester_id,
                        'allocated' => 1,
                    ]);
                }
            }
        }

        // if admin
        if(Gate::allows('isAdmin')){
        $searchMaterials = Material::where('semester_id',$req->semester_id)->with('getPdf')->get();
        $notAllocatedMaterials = Material::where('allocated', 0)
                     ->with('getPdf')
                     ->where('status', 1)
                     ->get();
        
        // search all semesters
        $semesters = Semister::where('department_id',$req->department_id)->with('materials')->get();
        
        }elseif(Gate::allows('isModarator')){
        $searchMaterials = Material::where('semester_id',$req->semester_id)->with('getPdf')->get();
        $notAllocatedMaterials = Material::where('allocated', 0)
                     ->with('getPdf')
                     ->where('status', 1)
                     ->where('author',Auth::user()->id)
                     ->get();
        
        // search all semesters
        $semesters = Semister::where('department_id',$req->department_id)->with('materials')->get();
        
        }
        
        return response()->json([
            "materials" => $searchMaterials,
            'notAllocated' => $notAllocatedMaterials,
            'semesters' => $semesters,
        ]);
    }

    // update materials and assigned pdfs into it
    public function assignPdfs(Request $req) {
        
        if($req->checkedPdfs){
            foreach($req->checkedPdfs as $pdfId) {
                $assign = Pdf::findOrFail($pdfId);
                if ($assign) { 
                    $assign->update([
                        'material_id' => $req->material_id,
                    ]);
                }
            }
        }

        $searchPdfs = Pdf::where('material_id',$req->material_id)->get();
        // if admin
        if(Gate::allows('isAdmin')){
            $notAllocatedPdfs = Pdf::where('material_id', null)
                     ->get();
        }elseif(Gate::allows('isModarator')){
            $notAllocatedPdfs = Pdf::where('material_id', null)
                     ->where('author',Auth::user()->id)
                     ->get();
        }

        return response()->json([
            "existPdfs" => $searchPdfs,
            'notAllocatedPdfs' => $notAllocatedPdfs,
        ]);
    }
    
    // remove assinged materials from semester
    public function removeAssignedMaterial(Request $req){

        $updateMaterial = Material::findOrFail($req->material_id);

        $updateMaterial->update([
            'university_id' => null,
            'semester_id' => null,
            'allocated' => 0,

        ]);

        // if admin
        if(Gate::allows('isAdmin')){
        // now search after remove materials
        $searchMaterials = Material::where('semester_id',$req->semester_id)->with('getPdf')->get();
        
        // now search updated not allocated materials
        $notAllocatedMaterials = Material::where('allocated', 0)
                     ->with('getPdf')
                     ->where('status', 1)
                     ->get();
          
        // search all semesters
        $semesters = Semister::where('department_id',$req->department_id)->with('materials')->get();
                     
        }elseif(Gate::allows('isModarator')){

        // now search after remove materials
        $searchMaterials = Material::where('semester_id',$req->semester_id)
                                    ->with('getPdf')
                                    ->get();
        
        // now search updated not allocated materials
        $notAllocatedMaterials = Material::where('allocated', 0)
                     ->with('getPdf')
                     ->where('status', 1)
                     ->where('author',Auth::user()->id)
                     ->get();
          
        // search all semesters based on department
        $semesters = Semister::where('department_id',$req->department_id)->with('materials')->get();
                     
        }
        
        return response()->json([
            "materials" => $searchMaterials,
            'notAllocated' => $notAllocatedMaterials,
            "semesters" => $semesters,
        ]);

    }

    // remove assinged pdfs from materials
    public function removeAssignedPdf(Request $req){

        $updatePdf = Pdf::findOrFail($req->pdf_id);

        $updatePdf->update([
            'material_id' => null,

        ]);

        // now search after remove pdfs
        $searchPdfs = Pdf::where('material_id',$req->material_id)->get();
        
        // if admin
        if(Gate::allows('isAdmin')){
            // now search updated not allocated pdfs
        $notAllocatedPdfs = Pdf::where('material_id', null)
        ->get();
        }elseif(Gate::allows('isModarator')){
            // now search updated not allocated pdfs
        $notAllocatedPdfs = Pdf::where('material_id', null)
        ->where('author',Auth::user()->id)
        ->get();
        }
                     
        return response()->json([
            "pdfs" => $searchPdfs,
            'notAllocated' => $notAllocatedPdfs,
        ]);

    }

    // method for update department
    public function updateDepartment(Request $req){
        $req->validate([
            'department' => 'required|string',
           ]);
           $department = Department::findOrFail($req->department_id);
           $department->update([
            'department' => $req->department,
           ]);
    
           return ['success' => $req->department .' Updated Successfully!'];
    }

    // method for add new departments
    public function addNewDepartment(Request $req){
        $admin = Auth::user()->id;
        $req->validate([
        'departments' => 'array',
        'departments.*' => 'nullable|string',
        ]);
        $output = [];
        foreach ($req->departments as $department) {
            if($department != NULL){
                $insert = Department::create([
                    'university_id' => $req->university_id,
                    'department' => $department,
                    'status' => 1,
                    'author' => $admin,
                ]);
                array_push($output,$insert);
            }
        }

        return response()->json(["success" => "true", "data" => $output]);
    }

    // method for update department
    public function adminUpdateDepartment(Request $req, $slug){
        
        
        $req->validate([
            'department' => 'regex:/^[A-Za-z0-9\s\(\)\-_]+$/|required|min:2',
            'university_id' => 'nullable|numeric',
            'status' => 'required|numeric',
        ]);

        $findDept = Department::where(compact('slug'))->first();

        $findDept->update([
            'university_id' => $req->university_id,
            'department' => $req->department,
            'status' => $req->status,
        ]);

        // After updating the department, update the materials and semesters table 

        // Update the semesters table
        $findSemesters = Semister::where('department_id', $findDept->id)->get();
        foreach ($findSemesters as $semester) {
            $semester->update([
                'university_id' => $req->university_id,
            ]);

        // Update the materials table
        $findMaterials = Material::where('semester_id', $semester->id)->get();
        foreach ($findMaterials as $material) {
            $material->update([
                'university_id' => $req->university_id,
            ]);
        }
        }

        return redirect()->route('admin.manage.department.update',$slug)->with('success',$req->department.' Updated Successfully!');
    }

    // method for update status
    public function updateStatus(Request $req){
        
        // if university
        if($req->key === 'university'){
            $find = Universitie::findOrFail($req->id);
            $find->update([
                'status' => $req->status,
            ]);

            return response()->json(['success' => true, 'status' => $req->status]);
        }elseif($req->key === 'department'){
            $find = Department::findOrFail($req->id);
            $find->update([
                'status' => $req->status,
            ]);

            return response()->json(['success' => true, 'status' => $req->status]);
        }elseif($req->key === 'material'){
            $find = Material::findOrFail($req->id);
            $find->update([
                'status' => $req->status,
            ]);

            return response()->json(['success' => true, 'status' => $req->status]);
        }

    }

    // method for assign department to user
    public function assignDepartmentToUser(Request $req){

        // first check if  user already assigned this department or not
        foreach ($req->departments as $department) {
            $checkUser = AssignUser::where('user_id',$req->user_id)
                                    ->where('department_id',$department)
                                    ->first();
            
            // if checkUser null then proceed
            if(!$checkUser){
                $assign = AssignUser::create([
                    'user_id' => $req->user_id,
                    'department_id' => $department,
                ]);
            }
        }
        
        // search for the assigned departments 
        $findAssignedDepartment = AssignUser::where('user_id',$req->user_id)
                                    ->with('getDepartment')                                        
                                    ->get();

        // get the IDs of the assigned departments
        $assignedDepartmentIds = $findAssignedDepartment->pluck('department_id');

        // find departments that are not assigned to the user for the given university
        $availableDepartments = Department::where('university_id', $req->university_id)
                                   ->whereNotIn('id', $assignedDepartmentIds)
                                   ->get();                            
        return response()->json(['status' => true,'id'=>$req->university_id, 'assignedDepartments' => $findAssignedDepartment,'departments' => $availableDepartments]);
 
    }

    // method for handle status update 
    public function updateListStatus(Request $req){
        
        if($req->key === 'university'){
            $search = Universitie::where('id',$req->id)->first();
        }elseif($req->key === 'department'){
            $search = Department::where('id',$req->id)->first();
        }elseif($req->key === 'material'){
            $search = Material::where('id',$req->id)->first();
        }elseif($req->key === 'faculty'){
            $search = Facultie::where('id',$req->id)->first();
        }elseif($req->key === 'user'){
            $search = User::where('id',$req->id)->first();
        }

        $search->update([
            'status' => $req->status 
        ]);

        return response()->json(['status' => $req->status]);
    }
}
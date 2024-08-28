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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDeleteController extends Controller
{
       // method for delete faculties
       public function deleteFaculties(string $slug){
        $delete = Facultie::where(compact('slug'))->delete();

        if($delete){
            return redirect()->route('admin.faculties')->with('delete','Deleted successfully!');
        }else{
            return redirect()->route('admin.faculties')->with('error','Failed!');
        }
    }

    // method for delete pdf
    public function deletePdf(Request $req){
    $pdf = Pdf::findOrFail($req->id);
    $title = $pdf->title;
    if (Storage::disk('public')->exists($pdf->pdf)) {
        Storage::disk('public')->delete($pdf->pdf);
    }
    $pdf->delete();

    return ['delete' => $title.' has been deleted!'];
    }

    // method for delete materials
    public function deleteMaterials(Request $req){
        $material = Material::findOrFail($req->id);
        $title = $material->title;

        // search those pdfs belongs this material_id and delete all of them
        $pdfs = Pdf::where('material_id',$req->id)->get();

        foreach($pdfs as $pdf){
            if (Storage::disk('public')->exists($pdf->pdf)) {
                Storage::disk('public')->delete($pdf->pdf);
            }
            $pdf->delete();
        }
        $material->delete();

        return ['delete' => $title.' has been deleted!'];
    }

    // method for delete selected materials

    public function selectedSemesterDelete(Request $req) {
        foreach($req->id as $semester_id) {
            $semester = Semister::findOrFail($semester_id);
    
            foreach ($semester->materials as $material) {
                $searchMaterial = Material::findOrFail($material->id);
    
                foreach($searchMaterial->getPdf as $pdf) {
                    $searchPdf = Pdf::findOrFail($pdf->id);
    
                    // If delete PDFs switch is on, delete the PDFs
                    if($req->isDeletePdf === "on") {

                        if (Storage::disk('public')->exists($searchPdf->pdf)) {
                            Storage::disk('public')->delete($searchPdf->pdf);
                        }

                        $searchPdf->delete();
                    }
                }
    
                // if delete PDFs switch is off and delete materials switch is on
                if ($req->isDeletePdf === "off" && $req->isDeleteMaterials === "on") {

                    Pdf::where('material_id', $material->id)->update([
                        "material_id" => null,
                    ]);
                }
    
                // if delete materials switch is on
                if($req->isDeleteMaterials === "on") {
                    $searchMaterial->delete();
                } else {
                    // if delete materials switch is off, unlink the material from the semester
                    $searchMaterial->update([
                        "semester_id" => null,
                        "allocated" => 0,
                    ]);
                }
            }
    
            $semester->delete();
        }
    
        $findSem = Semister::where('department_id', $req->department_id)->with('materials')->get();
    
        return response()->json(['success' => $req->id,'department_id' => $req->department_id, 'newSemesterData' => $findSem]);
    }
    

    // method for delete university
    public function deleteUniversity(Request $req){
        $University = Universitie::findOrFail($req->id);
        $title = $University->name;

        if (Storage::disk('public')->exists($University->image)) {
            Storage::disk('public')->delete($University->image);
        }

        $University->delete();

        return ['delete' => $title.' has been deleted!'];
    }

    // method for delete reviews
    public function deleteReviews(string $id){
        $delete = Review::find($id);
        
        if($delete){
            $delete->delete();
            return redirect()->route('admin.reviews',['key' => 'reviews'])->with('success','Deleted successfully!');
        }else{
            return ['message' => 'invalid!'];
        }
        
    }

     // method for delete pdfs
     public function deletePdfs(string $id){
        $delete = Pdf::find($id);
        
        if($delete){
            $delete->delete();
            return redirect()->route('admin.manage.pdf.list',['key' => 'pdfs'])->with('success','Deleted successfully!');
        }else{
            return ['message' => 'invalid!'];
        }
        
    }

    // method for delete selected departments
    public function deleteSelectedSemester(Request $req){
        foreach($req->id as $department_id) {
            $department = Department::findOrFail($department_id);

           
           $findSemesters = Semister::where('department_id', $department_id)->get();
           foreach($findSemesters as $semester){

           $findMaterials = Material::where('semester_id',$semester->id)->get();
           foreach($findMaterials as $material){
            $material->update([
                "university_id" => null,
                "semester_id" => null,
                "allocated" => 0,
               ]);
           }

           // Delete all associated semesters first
           $semester->delete();

           }

            
            
            $department->delete();
        }
    
        $findDept = Department::where('university_id', $req->universityId)->with('getSemesters')->get();
    
        return response()->json(['success' => $req->id, 'newDepartmentData' => $findDept]);
    }

    // method for delete departments form list
    public function deleteListDepartment($id) {
        
        $findDept = Department::findOrFail($id);
        $title = $findDept->deparment;

        $findSemesters = Semister::where('department_id',$id)->get();
        foreach ($findSemesters as $semester) {
            $findMaterials = Material::where('semester_id',$semester->id)->get();
            foreach($findMaterials as $material){
             $material->update([
                 "university_id" => null,
                 "semester_id" => null,
                 "allocated" => 0,
                ]);
            }
            $semester->delete();
        }

        $findDept->delete();

        return redirect()->route('admin.manage.department.list')->with(['delete' => $title.' has been deleted!']); 
    }

    // method for delete assigned department
    public function removeAssignedDepartment(Request $req) {
        // search assigned users 
        $assignUser = AssignUser::find($req->id);
        
        if ($assignUser) {
            $assignUser->delete();
        } else {
            return response()->json(['status' => false, 'message' => 'Assignment not found']);
        }
    
        // retrieve the updated list of assigned departments for the user
        $findAssignedDepartment = AssignUser::where('user_id', $req->user_id)
                                            ->with('getDepartment')
                                            ->get();
    
        // get the IDs of the assigned departments
        $assignedDepartmentIds = $findAssignedDepartment->pluck('department_id');
    
        // retrieve departments that are not assigned to the user for the given university
        $availableDepartments = Department::where('university_id', $req->university_id)
                                          ->whereNotIn('id', $assignedDepartmentIds)
                                          ->get();
    
        return response()->json([
            'status' => true,
            'assignedDepartments' => $findAssignedDepartment,
            'departments' => $availableDepartments
        ]);
    }

    // method for delete users
    public function deleteUser(Request $req)
{
    $userId = $req->input('user_id');
    $isDeleteMaterials = $req->input('isDeleteMaterials') === 'on';
    $isDeletePdf = $req->input('isDeletePdf') === 'on';

    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // check if we should delete related materials
    if ($isDeleteMaterials) {
        $user->materials()->delete();
    } else {
        $user->materials()->update(['author' => null]);
    }

    // check if we should delete related PDFs
    if ($isDeletePdf) {
        $user->pdf()->delete();
    } else {
        $user->pdf()->update(['author' => null]);
    }

    // update other related models
    $user->departments()->update(['author' => null]);
    $user->univerisity()->update(['author' => null]);
    $user->semester()->update(['author' => null]);
    $user->faculty()->update(['author' => null]);

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

    

}
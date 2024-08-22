<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Review;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
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

    // method for delete selected semester
    // public function selectedSemesterDelete(Request $req){

    //     foreach($req->id as $semester_id){
    //         $semester = Semister::findOrFail($semester_id);
            
    //         foreach ($semester->materials as $material) {
                
    //             $searchMaterial = Material::findOrFail($material->id);
    //             foreach($searchMaterial->getPdf as $pdf){
    //                 $searchPdf = Pdf::findOrFail($pdf->id);
    //                 if($req->isDeletePdf === "on" ){
    //                     if (Storage::disk('public')->exists($searchPdf->pdf)) {
    //                         Storage::disk('public')->delete($searchPdf->pdf);
    //                     }
    //                     $searchPdf->delete();
    //                 }
                    
    //             }
    //             if ($req->isDeletePdf === "off" && $req->isDeleteMaterials === "on") {
    //                 $findAllPdf = Pdf::where('material_id',$material->id)->get();
    //                 $findAllpdf->update([
    //                     "material_id" => null,
    //                 ]);
    //             }
    //             if($req->isDeleteMaterials === "on" ){
    //                 $searchMaterial->delete();
    //             }else{
    //                 $searchMaterial->update([
    //                     "semester_id" => null,
    //                     "allocated" => 0,
    //                 ]);
    //             }
    //         }
    //         $semester->delete();
         
    //     }

    //     $findSem = Semister::where('university_id',$req->universityId)->get();
    //     return ['success' => $req->id,'newSemesterData' => $findSem];
    // }

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
    
        $findSem = Semister::where('university_id', $req->universityId)->get();
    
        return response()->json(['success' => $req->id, 'newSemesterData' => $findSem]);
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

}
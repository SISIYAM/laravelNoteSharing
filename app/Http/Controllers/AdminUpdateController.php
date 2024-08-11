<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminUpdateController extends Controller
{
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
            'university_id' => 'required|numeric',
            'semester_id' => 'required|numeric',
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
            'university_id' => $req->university_id,
            'semester_id' => $req->semester_id,
            'title' => $req->title,
            'description' => $req->description,
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

    // method for add new semester while updating materials
    public function addNewSemester(Request $req){
        $admin = Auth::user()->name;
        $req->validate([
        'semesters' => 'array',
        'semesters.*' => 'nullable|string',
        ]);

        $output = [];
        foreach ($req->semesters as $semester) {
            if($semester != NULL){
                $insert = Semister::create([
                    'university_id' => $req->id,
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
        $admin = Auth::user()->name;

        $req->validate([
            'name' => 'alpha|required|min:2',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:3000',
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

}
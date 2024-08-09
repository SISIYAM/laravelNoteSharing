<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Http\Request;

class apiController extends Controller
{
    // method for fetchUniversity
    public function fetchUniversity(){

        $universities = Universitie::where('status',1)->with(['semisters' => function($query) {
            $query->where('status', 1);
        }, 'material' => function($material) {
            $material->where('status',1);
        }])->get();

        if($universities){
            return response()->json([
                'status' => true,
                'universities' => $universities,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'universities' => $universities,
                'message' => $slug.' not found!',
            ],404);
        }
    }

    // method for fetchSemesters
    public function fetchSemesters(){

        $semester = Semister::where('status',1)->with('university')->get();

        if($semester){
            return response()->json([
                'status' => true,
                'semesters' => $semester,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'semesters' => $semester,
                'message' => $slug.' not found!',
            ],404);
        }
    }

    // method for show university details
    public function showUniversityDetails(string $slug){

        $select = Universitie::where('slug',$slug)->where('status',1)->with(['semisters' => function($query){
            $query->where('status',1);
        },'semisters.materials'])->first();

        if($select){
            return response()->json([
                'status' => true,
                'select' => $select,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'select' => $select,
                'message' => $slug.' not found!',
            ],404);
        }
    }

    // method for fetch materials details
    public function fetchMaterialsDetails(string $slug = null){

        $material = Material::where('slug',$slug)->where('status',1)->with('getUniversity','getSemester','getPdf','getAuthor')->first();

        if($material){
            return response()->json([
                'status' => true,
                'material' => $material,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'material' => $material,
                'message' => $slug.' not found!',
            ],404);
        }
    }

    // method for fetch pdf details
    public function fetchPdfDetails(string $slug = null){

        $pdf = Pdf::where('slug',$slug)->with(['getMaterial' => function($query){
            $query->with('getUniversity','getSemester');
        },'getAuthor'])->first();

        if($pdf){
            return response()->json([
                'status' => true,
                'details' => $pdf,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'details' => $pdf,
                'message' => $slug.' not found!',
            ],404);
        }

    }

    // method for search 
    public function fetchSearch(string $query = null){
 
        $search = Material::with(['getAuthor', 'getUniversity', 'getSemester','getPdf'])
        ->where('status',1) // Ensure status is 1 
        ->where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->orWhere('slug','like',"%$query%")
        ->orWhereHas('getAuthor', function($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        })
        ->orWhereHas('getUniversity', function($q) use ($query) {
            $q->where('name', 'like', "%$query%")
            ->orWhere('slug','like',"%$query%");
        })
        ->orWhereHas('getSemester', function($q) use ($query) {
            $q->where('semister_name', 'like', "%$query%");
        })
        ->orWhereHas('getPdf', function($q) use ($query){
            $q->where('title','like',"%$query%")
            ->orWhere('slug','like',"%$query%");
        })
        ->get();
        
        if(count($search) != null){
            return response()->json([
                'status' => true,
                'search' => $search,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => $query." not found!",
            ]);
        }
    }

    // method for fetch faculties
    public function fetchFaculties () {
        $faculties = Facultie::where('status',0)->get();
        // return count($faculties);
        if(count($faculties)){
            return response()->json([
                'status' => true,
                'faculties' => $faculties,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'faculties' => $faculties,
                'message' => 'No result found!',
            ],404);
        }
    }
}
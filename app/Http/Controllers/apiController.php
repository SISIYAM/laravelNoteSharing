<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Review;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Semister;
use App\Models\Department;
use App\Models\Universitie;
use Illuminate\Http\Request;
use App\Models\MaterialRequest;
use Illuminate\Support\Facades\Validator;


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
       public function showUniversityDetails(string $slug = null){

        $select = Universitie::where('slug',$slug)->where('status',1)->first();

        if($select){
            // search departments 
            $getDepartment = Department::where('university_id', $select->id)
                            ->where('status',1)
                            ->with('getSemesters.materials')
                            ->get();

            if(!$getDepartment->isEmpty()){
                return response()->json([
                    'status' => true,
                    'select' => $select,
                    'department' => $getDepartment,
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => 'Departments not found or inactive!',
                ], 404);
            }
            
        }else{
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'select' => $select,
                'message' => $slug.' not found!',
            ],404);
        }
    }

    public function fetchDepartments(Request $req){
        $select = Universitie::where('slug', $req->university_slug)->where('status', 1)->first();

        if ($select) {
            $getDepartment = Department::where('slug', $req->slug)
                ->where('status', 1)
                ->with(['getSemesters' => function($query) {
                    $query->where('status', 1)
                        ->with(['materials' => function($query) {
                            $query->where('status', 1);
                        }]);
                }])
                ->first();

            if ($getDepartment) {
                return response()->json([
                    'status' => true,
                    'select' => $select,
                    'department' => $getDepartment,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => 'Department not found or inactive!',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => $req->university_slug . ' not found!',
            ], 404);
        }
    }



    // method for fetch materials details
    public function fetchMaterialsDetails(string $slug = null){

        $material = Material::where('slug',$slug)->where('status',1)->with('getUniversity','getSemester.getDepartment','getPdf','getAuthor')->first();

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
            $query->with('getUniversity','getSemester.getDepartment');
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
    // public function fetchSearch(string $query = null){
 
    //     $search = Material::with(['getAuthor', 'getUniversity', 'getSemester','getPdf'])
    //     ->where('status',1) // Ensure status is 1 
    //     ->where('title', 'like', "%$query%")
    //     ->orWhere('description', 'like', "%$query%")
    //     ->orWhere('slug','like',"%$query%")
    //     ->orWhereHas('getAuthor', function($q) use ($query) {
    //         $q->where('name', 'like', "%$query%");
    //     })
    //     ->orWhereHas('getUniversity', function($q) use ($query) {
    //         $q->where('name', 'like', "%$query%")
    //         ->orWhere('slug','like',"%$query%");
    //     })
    //     ->orWhereHas('getSemester', function($q) use ($query) {
    //         $q->where('semister_name', 'like', "%$query%");
    //     })
    //     ->orWhereHas('getPdf', function($q) use ($query){
    //         $q->where('title','like',"%$query%")
    //         ->orWhere('slug','like',"%$query%");
    //     })
    //     ->get();
        
    //     if(count($search) != null){
    //         return response()->json([
    //             'status' => true,
    //             'search' => $search,
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => false,
    //             'status_code' => 404,
    //             'message' => $query." not found!",
    //         ]);
    //     }
    // }
    public function fetchSearch(string $query = null){
        $search = Material::with(['getAuthor', 'getUniversity', 'getSemester.getDepartment', 'getPdf'])
            ->where('status', 1) // Ensure status is 1
            ->whereHas('getSemester',function($sem){ // ensure department is active
                $sem->whereHas('getDepartment',function($d){
                    $d->where('status',1);
                });
            })
            ->where(function ($queryBuilder) use ($query) {
                // Group all search conditions
                $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%")
                    ->orWhere('slug', 'like', "%$query%")
                    ->orWhereHas('getAuthor', function($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('getUniversity', function($q) use ($query) {
                        $q->where('name', 'like', "%$query%")
                            ->orWhere('slug', 'like', "%$query%");
                    })
                    ->orWhereHas('getSemester', function($q) use ($query) {
                        $q->where('semister_name', 'like', "%$query%");
                    })
                    ->orWhereHas('getPdf', function($q) use ($query) {
                        $q->where('title', 'like', "%$query%")
                            ->orWhere('slug', 'like', "%$query%");
                    });
            })
            ->get();
    
        if ($search->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'search' => $search,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => "$query not found!",
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

    // method for request for material api
    public function requestMaterial(Request $req) {
        
        $validator = Validator::make($req->all(), [
            "name" => "required|string|regex:/^[a-zA-Z\s]+$/",
            "department" => "required|string",
            "batch" => "required|alpha_num",
            "roll" => "required|numeric",
            "note" => "required"
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages()
            ],422);
        }

        $reqForMaterial = MaterialRequest::create([
            "studentName" => $req->name,
            "department" => $req->department,
            "batch" => $req->batch,
            "roll" => $req->roll,
            "note" => $req->note
        ]);

        return response()->json([
            "status" => 200,
            "message" => "Thanks for your request."
        ],200);
 
    }

    // method for submit submitReview
    public function submitReview(Request $req) {
        $validator = Validator::make($req->all(), [
            'rating' => 'required|numeric',
            'pdf_id' => 'required|numeric',
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'department' => 'required|string',
            'batch' => 'required|alpha_num',
            'review' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => 422,
                "errors" => $validator->messages()
            ],422);
        }

        $review = Review::create([
            'pdf_id' => $req->pdf_id,
            'rating' => $req->rating,
            'name' => $req->name,
            'department' => $req->department,
            'batch' => $req->batch,
            'review' => $req->review
        ]);

        return response()->json([
            "status" => 200,
            "message" => $req->name." Thanks for your review!"
        ],200);
    }

    // method for fetch reviews 
    public function fetchReviews(Request $req) {
        $review = Review::where('pdf_id',$req->pdf_id)->get();

        if(count($review)){
            return response()->json([
                'status' => 200,
                "review" => $review,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No review found!'
            ],404);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use App\Models\Facultie;
use App\Models\Material;
use App\Models\Universitie;
use Illuminate\Http\Request;

class pageController extends Controller
{
    // methods for load pages

    public function index(){
        // $universities = Universitie::where('status',1)->with(['semisters' => function($query) {
        //     $query->where('status', 1);
        // }, 'material'])->get();

        // return view('welcome',['universities' => $universities]);
        // return $universities;
        return view('admin.forms.login');
    }

    // method for show details page
    public function showDetails(string $slug = null){

        $select = Universitie::where('slug',$slug)->where('status',1)->with(['semisters' => function($query){
            $query->where('status',1);
        },'semisters.materials'])->first();

        return view('details',['data' => $select]);
        // return $select;
    }

    // method for show materials
    public function showMaterials(string $slug = null){

        $material = Material::where('slug',$slug)->where('status',1)->with('getUniversity','getSemester','getPdf','getAuthor')->first();

        return view('materials-details',['data' => $material]);
        // return $material;
    }

    // method for show faculty list
    public function showFacultiesList(){
        $faculties = Facultie::all();
        // return $faculties;
        return view('instructors',['data' => $faculties]);
    }

    // method for show pdf
    public function loadPdf(string $slug = null){
        $data = Pdf::where('slug',$slug)->with(['getMaterial' => function($query){
            $query->with('getUniversity','getSemester');
        },'getAuthor'])->first();
        return view('pdf-details',['data'=> $data]);
        // return $data;
    }

    // method for show search result
    public function loadSearchResult(Request $req){
        $search = Material::where('author',$req->input)->with('getUniversity','getSemester')->get();

        return $search;

    }

    public function showApi(){
        return response()->json([
            'name' => 'siyam',
        ],200);
    }
}
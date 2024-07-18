<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Universitie;
use Illuminate\Http\Request;

class pageController extends Controller
{
    // methods for load pages

    public function index(){
        $universities = Universitie::where('status',1)->with(['semisters' => function($query) {
            $query->where('status', 1);
        }, 'material'])->get();

        return view('welcome',['universities' => $universities]);
        // return $universities;
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

        $material = Material::where('slug',$slug)->where('status',1)->with('getUniversity','getSemester','getPdf')->first();

        return view('materials-details',['data' => $material]);
        // return $material;
    }
}

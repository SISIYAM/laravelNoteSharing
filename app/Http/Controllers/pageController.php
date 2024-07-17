<?php

namespace App\Http\Controllers;

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
    public function showDetails(string $id){

        $select = Universitie::where('id',$id)->where('status',1)->with(['semisters' => function($query){
            $query->where('status',1);
        },'semisters.materials'])->first();

        return view('details',['data' => $select]);
        // return $select;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // function for load registration form
    public function loadRegister(){
        return view('admin.forms.register');
    }

    // function for load login form
    public function loadLogin(){
        return view('admin.forms.login');
    }

    // function for validate and insert student account
    public function adminRegister(Request $req){

        // validate form input
        $req->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|email|required|unique:users',
            'password' => 'string|required|confirmed',
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
        ]);

        return redirect()->route('admin.dashboard');
    }

    // function for login
    public function adminLogin(Request $req){

        // validate form input
        $req->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);

        $credential = $req->only('email','password');
        if(Auth::attempt($credential)){
            $user = Auth::user();
            
            if(Auth::user()->role == 2 || Auth::user()->role == 1 ){
                
                // update last login time
                $user->last_login = now();
                $user->save();

                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('error.403');
            }
        }else{
            return redirect()->route('admin.load.login')->with('error','Email and password is incorrect');
        }
    }

    // method for logout
    public function logout(Request $req){
        $req->session()->flush();
        Auth::logout();
        return redirect()->route('home');
    }

}

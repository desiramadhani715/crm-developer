<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\historyprospect;
use App\Models\projectagent;
use App\Models\userPT;

class LoginController extends Controller
{
    public function login(){
        dd('fds');
        return view('login');
    }

    public static function postLogin(Request $request){
        // $kredensil = $request->only('UsernameKP','PasswordKP');
        // if(Auth::attempt($kredensil)){
        //     return redirect('/index');
        // }
        // return view('login');


        $data = [
            'UsernameKP'     => $request->input('UsernameKP'),
            'PasswordKP'  => $request->input('PasswordKP'),
        ];
        dd($data);

        Auth::attempt($data);

        if (Auth::check()) {

            return redirect()->route('/index');

        } else {

            Session::flash('error', 'Email atau password salah');
            return redirect()->to('/');
        }


        $agent = projectagent::get_project_agent($request->UsernameKP);

        $total_leads = historyprospect::get_total_leads($request->UsernameKP);

        $new = historyprospect::get_new($request->UsernameKP);

        $user = User::where('UsernameKP', '=', $request->UsernameKP)->first();

        $namaPT = userPT::get_PT($request->UsernameKP);


        // if($user){
        //     if (Hash::check($request->PasswordKP, $user->PasswordKP)) {
        //         return view('/index',compact('agent','total_leads','namaPT'));
        //     }
        // }
        // else{
        //     Session::flash('error', 'Email atau password salah');
        //     return redirect()->to('/');
        // }

    }

    public function register(){
        return view('register');
    }

    public function create(Request $request){
        User::create([
            'UsernameKP' => $request->UsernameKP,
            'PasswordKP' => bcrypt($request->PasswordKP),
            'Email' => $request->Email,
            'LevelUserID' => 'admin_int',
            'remember_token' => Str::random(60)
        ]);
        return redirect()->to('/')->with('status',"Register Succsess");
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
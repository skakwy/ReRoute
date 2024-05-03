<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
     
            $services = DB::select('select * from service');

            return view('welcome')->with('services', $services);
    }
    public function login($name,$password){
        $user = DB::select('select id, password from users where name = ?', [$name]);
        $isRight = Hash::check($password, $user[0]->password);
        
        if ($isRight) {
            Auth::loginUsingId($user[0]->id);
            return redirect('/');
        }
        else {
            return redirect('/login/true');
        }
    }
    public function loginPage(?string $failed = null){
        if ($failed) {
            return view('login')->with('error', true);
        }
        else{
            return view('login')->with('error', false);;
        }
    }
    public function addService($name, $ip, $isHttps = "false"){
        if($isHttps == "true"){
            $isHttps = 1;
        }
        else{
            $isHttps = 0;
        }
        $ip = str_replace("'","",$ip);
  
            DB::insert('insert into service (name, url, isHttps) values (?, ?, ?)', [$name, $ip, $isHttps]);
        return redirect('/');
        

    }
    public function changeService($oldName, $isHttps = "false", $newName, $newIp){
        if($isHttps == "true"){
            $isHttps = 1;
        }
        else{
            $isHttps = 0;
        }
        $newIp = str_replace("'","",$newIp);
     
            DB::update('update service set name = ?, url = ?, isHttps = ?  where name = ?', [$newName, $newIp,$isHttps, $oldName]);
    
        return redirect('/');
        

    }
    public function deleteService($name){

            DB::delete('delete from service where name = ?', [$name]);
        
        return redirect('/');
    }
    public function dashboard(){
    
            return view('dashBoard');
 
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
  
}

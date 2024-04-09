<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class MainController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $services = DB::select('select * from service');

            return view('dashBoard');
        }
        else {
            
            return redirect('/login');
        }
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
        if(Auth::check()){
            DB::insert('insert into service (name, url, isHttps) values (?, ?, ?)', [$name, $ip, $isHttps]);
        }
        return redirect('/');
        

    }
    public function cpuUsage(){
        $command = ['bash', '-c', "top -b -n1 | grep \"Cpu(s)\" | awk '{print $2 + $4}'"];
        $process = new Process($command);
        $process->run();
    
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return "CPU Usage: ".$process->getOutput()."%";
    
        // if(Auth::check()){
            
        // }
        // else{
        //     return redirect('/');
        // }
    }
}

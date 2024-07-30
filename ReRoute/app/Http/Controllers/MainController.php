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

            return view('welcome')->with('services', $services);
        } else {

            return redirect('/login');
        }
    }
    public function login($name, $password)
    {
        $user = DB::select('select id, password from users where name = ?', [$name]);
        $isRight = Hash::check($password, $user[0]->password);

        if ($isRight) {
            Auth::loginUsingId($user[0]->id);
            return redirect('/');
        } else {
            return redirect('/login/true');
        }
    }
    public function loginPage(?string $failed = null)
    {
        if ($failed) {
            return view('login')->with('error', true);
        } else {
            return view('login')->with('error', false);
            ;
        }
    }
    public function addService($name, $ip, $isHttps = "false")
    {
        if ($isHttps == "true") {
            $isHttps = 1;
        } else {
            $isHttps = 0;
        }
        $ip = str_replace("'", "", $ip);
        if (Auth::check()) {
            DB::insert('insert into service (name, url, isHttps) values (?, ?, ?)', [$name, $ip, $isHttps]);
        }
        return redirect('/');


    }
    public function changeService($oldName, $isHttps = "false", $newName, $newIp)
    {
        if ($isHttps == "true") {
            $isHttps = 1;
        } else {
            $isHttps = 0;
        }
        $newIp = str_replace("'", "", $newIp);
        if (Auth::check()) {
            DB::update('update service set name = ?, url = ?, isHttps = ?  where name = ?', [$newName, $newIp, $isHttps, $oldName]);
        }
        return redirect('/');


    }
    public function deleteService($name)
    {
        if (Auth::check()) {
            DB::delete('delete from service where name = ?', [$name]);
        }
        return redirect('/');


    }
    public function cpuUsage()
    {
        $command = ['bash', '-c', "top -b -n1 | grep \"Cpu(s)\" | awk '{print $2 + $4}'"];
        $process = new Process($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return "CPU Usage: " . $process->getOutput() . "%";


    }
    public function updateEvcc()
    {
        if (Auth::check()) {
            //TODO: get port from database
            $port = 7070;
            $command = ['bash', '-c', "sudo docker run -d --network=host -p $port:7070 -p 7090:7090/udp -p 8887:8887 -p 9522:9522/udp --name evcc --restart=always -v /home/pi/evcc/etc/evcc.yaml:/etc/evcc.yaml -v /home/pi/evcc/data:/root/.evcc --restart=always evcc/evcc:latest"];
            $process = new Process($command);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                return new ProcessFailedException($process);
                
            }
          
            //redirect('/');


        }
    }
}

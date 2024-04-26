<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DockerCom extends Controller
{
   
    public function cpuUsage() 
    {
        if (Auth::check()) {
            $linfo = new \Linfo\Linfo;
            $parser = $linfo->getParser();
            $cpu = $parser->getCPU();
            var_dump($cpu);
            return response(null,200);
        } else {
            return response(null, 403);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DockerCom extends Controller
{
   
    public function cpuUsage() 
    {
  
            return response(null,304);
     
    }

}

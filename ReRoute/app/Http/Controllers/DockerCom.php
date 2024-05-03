<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DockerCom extends Controller
{
   
    public function cpuUsage() 
    {
            $socket = $this->socketRequest("GET /containers/json");
            return response(null,304);
     
    }
    private function socketRequest($request){
        $socket = stream_socket_client("unix:///app/docker.sock", $errno, $errstr);
        if(!socket){
            return response(null,500);
            fwrite($socket, $request);
            while (!feof($socket)) {
                $response = fread($socket, 1024);
            }
        }
        return response(null,304);
    }

}

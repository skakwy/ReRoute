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

        //$response = $this->socketRequest("/containers/87b93e04ba4e65265a6db5ccf0941e8434c0156a694f2ec7cc8b3a885ff17077/stats?stream=false",true);
        $response = json_decode('{"read":"2024-05-03T17:03:08.713388179Z","preread":"2024-05-03T17:03:07.709619595Z","pids_stats":{"current":11,"limit":1.8446744073709552e+19},"blkio_stats":{"io_service_bytes_recursive":[{"major":254,"minor":0,"op":"read","value":24576},{"major":254,"minor":0,"op":"write","value":139264}],"io_serviced_recursive":null,"io_queue_recursive":null,"io_service_time_recursive":null,"io_wait_time_recursive":null,"io_merged_recursive":null,"io_time_recursive":null,"sectors_recursive":null},"num_procs":0,"storage_stats":[],"cpu_stats":{"cpu_usage":{"total_usage":1415706000,"usage_in_kernelmode":185114000,"usage_in_usermode":1230591000},"system_cpu_usage":53006070000000,"online_cpus":10,"throttling_data":{"periods":0,"throttled_periods":0,"throttled_time":0}},"precpu_stats":{"cpu_usage":{"total_usage":1415706000,"usage_in_kernelmode":185114000,"usage_in_usermode":1230591000},"system_cpu_usage":52996040000000,"online_cpus":10,"throttling_data":{"periods":0,"throttled_periods":0,"throttled_time":0}},"memory_stats":{"usage":50634752,"stats":{"active_anon":49442816,"active_file":0,"anon":49442816,"anon_thp":41943040,"file":57344,"file_dirty":0,"file_mapped":0,"file_writeback":0,"inactive_anon":0,"inactive_file":57344,"kernel_stack":180224,"pgactivate":0,"pgdeactivate":0,"pgfault":31766,"pglazyfree":0,"pglazyfreed":0,"pgmajfault":0,"pgrefill":0,"pgscan":0,"pgsteal":0,"shmem":0,"slab":547904,"slab_reclaimable":155296,"slab_unreclaimable":392608,"sock":4096,"thp_collapse_alloc":0,"thp_fault_alloc":114,"unevictable":0,"workingset_activate":0,"workingset_nodereclaim":0,"workingset_refault":0},"limit":8221937664},"name":"\/lucid_wright","id":"87b93e04ba4e65265a6db5ccf0941e8434c0156a694f2ec7cc8b3a885ff17077","networks":{"eth0":{"rx_bytes":30396,"rx_packets":69,"rx_errors":0,"rx_dropped":0,"tx_bytes":5024,"tx_packets":49,"tx_errors":0,"tx_dropped":0}}}');
        $cpu_delta = $response->cpu_stats->cpu_usage->total_usage - $response->precpu_stats->cpu_usage->total_usage;
        $system_cpu_delta = $response->cpu_stats->system_cpu_usage - $response->precpu_stats->system_cpu_usage;
        $number_cpus = $response->cpu_stats->online_cpus;
        $cpuUsage = ($cpu_delta / $system_cpu_delta) * $number_cpus * 100.0;
        return response($cpuUsage, 200);

    }
    private function socketRequest($request,$isGet)
    {
        $socket = stream_socket_client("unix:///app/docker.sock", $errno, $errstr);
        if(!$isGet){
            $request = "POST " . $request . " HTTP/1.0\r\nHost: localhost\r\nAccept: */*\r\n\r\n";
        }
        else{
            $request = "GET " . $request . " HTTP/1.0\r\nHost: localhost\r\nAccept: */*\r\n\r\n";
        }
        $response = "";

        if ($socket) {
            stream_set_timeout($socket, 5);

            fwrite($socket, $request);
            while (!feof($socket)) {
                $response .= fread($socket, 1024);
                //check for timeout
                $info = stream_get_meta_data($socket);
                if ($info['timed_out']) {
                    break;
                }
            }
            fclose($socket);
            //remove http headers
            $response = substr($response, strpos($response, "\r\n\r\n") + 4);

            $jsonResponse = json_decode($response);
        
            return $jsonResponse;
        }

    }

}

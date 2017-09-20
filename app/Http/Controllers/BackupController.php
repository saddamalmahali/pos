<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index(){
        $folder = "http---localhost/";
        $files = Storage::files($folder);
        $data = array();
        foreach ($files as $file) {
            $length_folder = strlen($folder);
            $length_file = strlen($file)-$length_folder;

            array_push($data, substr($file, $length_folder, $length_file));
            
        }
        return view('admin.backup.index', ['data'=>$data]);
    }

    public function get_file($name)
    {
        $folder = 'http---localhost/'.$name;

        $file = Storage::disk('local')->get($folder);

        return response()->download(storage_path("app/".$folder));
    }


}

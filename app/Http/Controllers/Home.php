<?php

namespace App\Http\Controllers;

use App\Models\Datasensor;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Events\DataCreate;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class Home extends BaseController{
    public function index(){
        $data = Datasensor::with('status')->orderBy('id', 'DESC')->first();                    
        return view('Home.index',compact('data'));
    }

    public function getData(){
        $data = Datasensor::with('status')->orderBy('id', 'DESC')->first();
        return response()->json([
            'data' => $data
        ]);
    }
    
    public function getDataToTable(){
        $data = Datasensor::with('status')->orderBy('id', 'DESC')->take(50)->get();
        return response()->json([
            'data' => $data
        ]);        
    }

    public function sendData(Request $request){
        $suhu = $request->suhu;
        $kl = $request->kelembapan;     
        $st = $request->status;

        Datasensor::create([
            'suhu' => $suhu,
            'kelembapan' => $kl,
            'status_id'  => $st,
            'created_at' => Carbon::now()
        ]);

        broadcast(new DataCreate("hai"));
        
        return response()->json([
            'success' => 200
        ]);
    }
}
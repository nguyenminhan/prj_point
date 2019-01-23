<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\APIHelper;
// use Illuminate\Support\Facades\Session;
// use GuzzleHttp\Client;

class PointsController extends Controller
{


    protected $pointapi;

    public function __construct()
    {
        $this->pointapi = new APIHelper();
    }
    public function point(){

    	
    	
    	// $jsonString = file_get_contents(base_path('resources/lang/rank.json'));
    	// $data = json_decode($jsonString, true);
    	// dd($data);
    	return view('point.index');
    }

    public function getpoint(Request $request){

    	$data_all = $request->all();
    	$item = [
    		["transactionUuid" => $data_all['transactionUuid']]
    	];

    	$params = [
				"conditions" => $item ,
				"order" => ["transactionHeadId"],
				"table_name" => "TransactionHead"
				];
    	$data = [
    		"proc_name" => "transaction_ref",
    		"params" => json_encode($params, true)
    	];

    	$rs =  $this->pointapi->getApi($data);
 
    	$rs = json_decode($rs,true);

    	$get_customer = $rs['result'];


    	return redirect()->route('getCustomer', compact('get_customer'));
    }

    public function getCustomer(Request $req){
    	echo "ok";
    }
}

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
        dd($data_all);
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
        $return ="";
        $check = false;
        $getAllCustomer = $this->getAllCustomer();
        foreach ($get_customer as $value) {
            foreach ($getAllCustomer as $value1) {
                if($value['customerId'] == $value1['customerId'] ){
                    $check = true;
                    break;
                }
            }
        }
        if(!$check){
            echo "khong ton tai ma bien lai";
        }else{
             echo $value['point'];
        }
        
     

    }

    public function getAllCustomer(){

        $params = [
                "fields" => ["customerCode","lastName","firstName","customerId"],
                "table_name" => "Customer"
                ];
        $data = [
            "proc_name" => "customer_ref",
            "params" => json_encode($params, true)
        ];

        $rs =  $this->pointapi->getApi($data);
        $rs = json_decode($rs,true);
        return $rs['result'];
    	// dd($customer_id);
    }
}

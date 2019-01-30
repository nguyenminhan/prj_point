<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\APIHelper;
use DB;


class PointsController extends Controller
{

    protected $pointapi;

    public function __construct()
    {
        $this->pointapi = new APIHelper();
    }
    public function point(){

        $point_history = DB::table('point')->select('transactionUuid')->get();
        $transactionUuid =[];
        foreach ($point_history as $key => $value) {
            $transactionUuid[] =  $value->transactionUuid;
        }
    	return view('point.index',compact('transactionUuid'));
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
    	$get_point = $rs['result'];
       dd($get_point);
    	// goi api tra ve customer
    
    	$item1 = [
    		["customerCode" => $data_all['customer_code']]
    	];

    	$params1 = [
    			"fields" => ["customerCode","lastName","firstName","customerId","rank","point"],
				"conditions" => $item1 ,
				"order" => ["customerCode desc"],
				"table_name" => "Customer"
				];
    	$data1 = [
    		"proc_name" => "customer_ref",
    		"params" => json_encode($params1, true)
    	];

    	$rs1 =  $this->pointapi->getApi($data1);

 
    	$rs1 = json_decode($rs1,true);

    
    	$get_customer = $rs1['result'][0]['customerCode'];

    	$point_current =  $rs1['result'][0]['point'];

    	// goi api tra ve price
    	
    	$price_api=0;
    	foreach ($get_point  as  $value) {
    		if($get_customer == $value['customerCode']){
    			$price = $this->getPriceByTractionHeadID($value['transactionHeadId']);
    			$price_api+=$price;
    			
    		}
    	}
    	$jsonRank = file_get_contents(base_path('resources/lang/rank.json'));
    	$jsonRank = json_decode($jsonRank, true);
    	$rank = $rs1['result'][0]['rank'];
    	$point_new=0;
		$check = false;
    	foreach ($jsonRank as  $value) {
    		if((int)$value['number'] == (int) $rank){
    			$point_new += (int)($price_api/100) * $value['point'];
    			$check = true;
    			break;
    		}
    	}
    	if(!$check){
    		swal("エラーになりました。", "don't  exits rank!", "warning");
    	}

 		$point_total = (int)$point_current + $point_new;

 		$data_point = [
 			'transactionUuid' => $data_all['transactionUuid'],
 			'customerCode'    => $data_all['customer_code'],
 			'point_current'   => $point_current,
 			'point_new'		  => $point_new,
 			'point_total'	  => $point_total
 		];


 		DB::table('point')->insert($data_point);

    	$update_point = $this->updatePoint($point_total,$rs1['result'][0]['customerId']);
    	return $update_point;  

    	  

    }

    public function getPriceByTractionHeadID($transactionHeadId){

    	$item = [
    		["transactionHeadId" => $transactionHeadId]
    	];

        $params = [
                "conditions" => $item,
                "order" => ["transactionHeadId","transactionDetailId"],
                "table_name" => "TransactionDetail"
                ];
        $data = [
            "proc_name" => "transaction_ref",
            "params" => json_encode($params, true)
        ];

        $rs =  $this->pointapi->getApi($data);
        $rs = json_decode($rs,true);

        $price=0;
    	foreach ($rs['result']  as  $value) {
    		$price+=($value['salesPrice'] * $value['quantity']) ;
    	}
        return $price;
    }
    public function updatePoint($point,$customer_id){
    	$proc_info = [
	    		"proc_division" => "U",
	    		"proc_detail_division" => "1"
    	];
    	$row = [
    		[
    			"customerId" => $customer_id,
    			"point" => $point
    		]
    	];
    	$data = [
    		[
    			"table_name" => "Point",
    			"rows" => $row
    		]
    	];

        $params = [
                "proc_info" => $proc_info,
                "data" => $data
            ];
        $point_update = [
            "proc_name" => "point_upd",
            "params" => json_encode($params,true)
        ];   		
         $this->pointapi->getApi($point_update);
        // return $rs;
        return $point;
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\APIHelper;


class PointsController extends Controller
{


    protected $pointapi;

    public function __construct()
    {
        $this->pointapi = new APIHelper();
    }
    public function point(){
    	return view('point.index');
    }

    public function getpoint(Request $request){

    	$data_all = $request->all();
        
        // goi api tra ve point
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


    	// goi api tra ve customer
    
    	$item1 = [
    		["customerCode" => $data_all['customer_code']]
    	];

    	$params1 = [
    			"fields" => ["customerCode","lastName","firstName","customerId","rank"],
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
    	$point=0;
		$check = false;
    	foreach ($jsonRank as  $value) {
    		if((int)$value['number'] == (int) $rank){
    			$point += (int)($price_api/100) * $value['point'];
    			$check = true;
    			break;
    		}
    	}
    	if(!$check){
    		swal("Fail!", "Không tồn tại rank!", "warning");
    	}
 
    	$update_point = $this->updatePoint($point,$rs1['result'][0]['customerId']);
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
    		$price+=$value['price'];
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

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
       
    	return view('point.index');
    }

    public function getpoint(Request $request){
		$data_all = $request->all();
        $count_point = DB::table(env('MODEL_TABLE'))
        ->where('transactionUuid', '=', $data_all['transactionUuid'])
        ->count();


        if($count_point > 0) {
            return json_encode(array(
                'error_code'  => 8,
                'error_msg' => 'すでにこのレシートは登録されています。'
            ));
            die;
        }
        // goi api tra ve transactionHeadId
        
        $item = [
    		[
                "transactionUuid" => $data_all['transactionUuid'],
                "transactionHeadDivision" => "1",
                "storeId <>" => "40"
            ]
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
        if(empty($get_point)) {
            return json_encode(array(
                'error_code'  => 4,
                'error_msg' => 'レシートIDが存在しません。'
            ));
            die;
        }
        $check2 = false;
        foreach ($get_point as $value) {
            if ($value['storeId'] != "39" &&  $value['storeId'] != "1") {
                $check2 = true;
                break;
            }
        }
        if(!$check2){
            return json_encode(array(
                'error_code'  => 3,
                'error_msg' => 'エラーが発生しました'
            ));
            die;
        }
        

    	// goi api tra ve customer
    	$item1 = [
    		["customerCode" => $data_all['customer_code']]
    	];

    	$params1 = [
            "fields" => ["customerCode","lastName","firstName","customerId","rank","point","customerNo","sex","pointGivingUnitPrice","pointGivingUnit"],
            "conditions" => $item1 ,
            "order" => ["customerCode desc"],
            "table_name" => "Customer"
        ];
    	$data1 = [
    		"proc_name" => "customer_ref",
    		"params" => json_encode($params1, true)
    	];
    	$rs1 =  $this->pointapi->getApi($data1);

    	$rs1 = json_decode($rs1, true);
        if(empty($rs1['result'])){
            return json_encode(array(
                'error_code'  => 5,
                'error_msg' => '会員が存在しません。'
            ));
            die;
        }else{
            $get_customer = $rs1['result'][0]['customerCode'];
            $point_current =  $rs1['result'][0]['point'];
            $customerId = $rs1['result'][0]['customerId'];
            $lastName = $rs1['result'][0]['lastName'];
            $firstName = $rs1['result'][0]['firstName'];
            $sex = $rs1['result'][0]['sex'];
            $customerNo =  $rs1['result'][0]['customerNo'];
        }       


        // $date_api = date('Y-m-d H:i:s', $date_api);
        // echo $date_api."<br>";
       
        

    	// goi api tra ve price
    	   $price_api = 0;
        // $check1 = false;
    	// foreach ($get_point  as  $value) {
        
            // check receipt quá 3 tháng thì k được update point
            // echo $date_current."<br>";die;
            $date_api = $get_point[0]['transactionDateTime'];

            $date_api = strtotime($date_api);
                // $date_api = date('Y-m-d H:i:s', $date_api);
            $date_api = mktime(date("H",$date_api), date("i",$date_api), date("s",$date_api), date("m", $date_api)+3, date("d", $date_api),   date("Y", $date_api));
            $date_current = date('Y-m-d H:i:s');
            $date_current = strtotime($date_current);
            if($date_api >= $date_current){
                if($get_customer == $get_point[0]['customerCode']) {
                    return json_encode(array(
                        'error_code'  => 6,
                        'error_msg' => 'すでにこのレシートは登録されています。'
                    ));
                }else{
                    $price_api +=  $get_point[0]['subtotal'];
                    // cộng thêm 1 năm để update
                    $terminalTranDateTime_api =  $get_point[0]['terminalTranDateTime'];
                    $terminalTranDateTime_api = strtotime($terminalTranDateTime_api);
                    $terminalTranDateTime_api = mktime(date("H",$terminalTranDateTime_api), date("i",$terminalTranDateTime_api), date("s",$terminalTranDateTime_api), date("m", $terminalTranDateTime_api), date("d", $terminalTranDateTime_api),   date("Y", $terminalTranDateTime_api)+1);
                    $terminalTranDateTime_api = date('Y-m-d', $terminalTranDateTime_api);

                    $this->updateCustomer($customerId,$get_customer,$customerNo,$lastName,$firstName,$sex,$terminalTranDateTime_api);
                }
            }else{
                return json_encode(array(
                    'error_code'  => 9,
                    'error_msg' => 'レシートの期限は三か月までです。このレシートは期限切れになりました。'
                ));
                exit();
            }
              
            

                // $price_api += $value['subtotal'];
                // $check1 = true;
                // break;    
            // }
            	
    	// }
        // if(!$check1){
        //     return json_encode(array(
        //         'error_code'  => 9,
        //         'error_msg' => 'レシートの期限は三か月までです。このレシートは期限切れになりました。'
        //     ));
        //     exit();
        // }
    	$jsonRank = file_get_contents(base_path('resources/lang/rank.json'));
    	$jsonRank = json_decode($jsonRank, true);
    	$rank = $rs1['result'][0]['rank'];
    	$point_new=0;
		$check3 = false;
    	foreach ($jsonRank as  $value) {
    		if((int)$value['number'] == (int)$rank){
                if($price_api > 0){
                    $point_new += (int)($price_api/100) * $value['point'];
                }
                // if($get_point[0]['subtotal'] > 0){
                //     $point_new += (int)($get_point[0]['subtotal'] /100 ) * $value['point'];
                // }
                
    			$check3 = true;
    			break;
    		}
    	}
    	if(!$check3){
            return json_encode(array(
                'error_code'  => 7,
                'error_msg' => 'このランクが存在しません。'
            ));
            exit();
    	}

 		$point_total = (int)$point_current + $point_new;

       
    
            $data_point = [
            'transactionUuid' => $data_all['transactionUuid'],
            'customerCode'    => $data_all['customer_code'],
            'point_current'   => $point_current,
            'point_new'       => $point_new,
            'point_total'     => $point_total,
            'create_at'       => date('Y-m-d H:i:s'),
            'update_at'       => date('Y-m-d H:i:s')
            ];

            DB::table(env('MODEL_TABLE'))->insert($data_point);

            $update_point = $this->updatePoint($point_total,$customerId);
            // return $update_point;
            return json_encode(array(
                'error_code'  => 0,
                'id' => $update_point,
                
            ));
  

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

    public function updateCustomer($customer_id,$customerCode,$customerNo,$lastName,$firstName,$sex,$pointExpireDate){
        $proc_info = [
                "proc_division" => "U"
        ];
        $row = [
            [
                "customerId" => $customer_id,
                "customerCode" => $customerCode,
                "customerNo" =>$customerNo ,
                "lastName" =>$lastName ,
                "firstName" =>$firstName ,
                "sex" => $sex,
                "pointExpireDate" => $pointExpireDate
            ]
        ];
        $data = [
            [
                "table_name" => "Customer",
                "rows" => $row
            ]
        ];

        $params = [
                "proc_info" => $proc_info,
                "data" => $data
            ];
        $customer_update = [
            "proc_name" => "customer_upd",
            "params" => json_encode($params,true)
        ];          
        $rs = $this->pointapi->getApi($customer_update);
        return $rs;
    }
    
}

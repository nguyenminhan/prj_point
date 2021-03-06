@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center" style="font-size: 25px;">会員ポイント付与アプリ</div>
                    <div class="panel-body">   
                        <div class="form-group">
                            <label for="customer_code"><b>会員番号：</b></label>          
                            <input type="text" class="form-control" name="customer_code" id="customer_code" placeholder="customerCode"">
                        </div>
                        <div class="form-group"> 
                            <label for="customer_code"><b>レシート：</b></label>                             
                            <input type="text" class="form-control" name="transactionUuid" id="transactionUuid" placeholder="transactionUuid">
                        </div>
                        <div class="form-group"> 
                            <button type="button" id="ok" class="btn btn-primary">送信する</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">   
  var url = "{{route('point')}}"
</script>
@endsection
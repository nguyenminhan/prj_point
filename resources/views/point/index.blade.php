@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center" style="font-size: 25px;">Point後付けWebアプリ</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="">
                        @csrf
                        <div class="form-group">
                              <label class="control-label col-sm-3" for="mathanhvien"></label>
                            <div class="col-sm-6"> 
                                
                            <input type="text" class="form-control" name="customer_code" id="customer_code" placeholder="customerCode"  style="height: 45px;">
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="mathanhvien"></label>
                            <div class="col-sm-6"> 
                               
                                <input type="text" class="form-control" name="transactionUuid" id="transactionUuid" placeholder="transactionUuid" style="height: 45px;">
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-sm-offset-7 col-sm-9">
                                <button type="button" id="ok" class="btn btn-primary">OK</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
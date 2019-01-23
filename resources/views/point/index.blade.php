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
                            <label class="control-label col-sm-3" for="mathanhvien">会員番号:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mathanhvien" placeholder="Mã thành viên" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                              <label class="control-label col-sm-3" for="mathanhvien"></label>
                            <div class="col-sm-6"> 
                                
                                <input type="text" class="form-control" name="customer_code"  placeholder="customerCode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="pwd">レシート:</label>
                            <div class="col-sm-6"> 
                                <input type="text" class="form-control" name="bienlai" placeholder="receipt" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="control-label col-sm-3" for="mathanhvien"></label>
                            <div class="col-sm-6"> 
                               
                                <input type="text" class="form-control" name="transactionUuid" id="transactionUuid" placeholder="transactionUuid">
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-sm-offset-7 col-sm-9">
                                <button type="submit" id="ok" class="btn btn-primary">OK</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
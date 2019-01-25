@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center" style="font-size: 25px;">Point後付けWebアプリ</div>
                <div class="panel-body">
                    {{-- <form action="/k"> --}}
                        <div class="form-group">
                            <label for="customer_code"><b>会員番号：</b></label>          
                            <input type="text" class="form-control" name="customer_code" id="customer_code" placeholder="customerCode"   style="height: 45px;">
                        </div>
                        <div class="form-group"> 
                            <label for="customer_code"><b>レシート：</b></label>                             
                            <input type="text" class="form-control" name="transactionUuid" id="transactionUuid" placeholder="transactionUuid" style="height: 45px;">
                        </div>
                        <div class="form-group"> 
                            <div class="col-sm-offset-7 col-sm-9">
                                <button type="button" id="ok" class="btn btn-primary">OK</button>
                        </div>
                    {{-- </form> --}}
                            {{-- </div> --}}
                        {{-- </div> --}}
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
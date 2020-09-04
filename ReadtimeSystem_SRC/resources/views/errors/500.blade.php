@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L10.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <div class="row">
    <div class="col-md-12">
      <h3 class="text-danger">システムエラーが発生しました。</h3>
      <p class="text-danger">大変申し訳ございません。<br/>
      サーバーが混み合っているか、プログラム誤作動によるエラーが発生しました。<br/>
      早急に対応させて頂きます。<br/>
      ご迷惑お掛けいたしまして、大変申し訳ございません。<br/>
      しばらく経ってから再度ご利用くださいますようお願い申し上げます。</p>
    </div>
  </div>
@endsection
 
@include('layout.footer')

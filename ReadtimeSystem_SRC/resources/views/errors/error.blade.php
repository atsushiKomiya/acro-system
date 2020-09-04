@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L10.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <div class="row">
    <div class="col-md-12 m-10">
      <h3 class="text-danger">{{ $message }}</h3>
    </div>
  </div>
@endsection
 
@include('layout.footer')

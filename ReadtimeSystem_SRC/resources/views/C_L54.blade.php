@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L54.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <dateselect></dateselect>
@endsection
 
@include('layout.footer')

@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L50.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <depolist 
  :preflist='@json($prefList)'
  :dispgrouptypelist='@json($displayGroupTypeList)'
  :depolist='@json($depoList)'
  :ismulti="@json($isMulti)"></depolist>
@endsection
 
@include('layout.footer')

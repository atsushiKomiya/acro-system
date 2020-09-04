@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L55.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
<areaselect
:citylist='@json($cityList->values())'
:preflist='@json($prefList->values())'
:isaddress='@json($isAddress)'></areaselect>
@endsection
 
@include('layout.footer')

@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L30.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <irregularlist
    :irregular-config-classification-list='@json($irregularConfigClassificationList)'
    :c-use-list='@json($cUseList)'
    :valid-list='@json($validList)'
    :delivery-date-list='@json($deliveryDateList)'
    :irregular-list='@json($irregularList)'
    >
  </irregularlist>
@endsection

@include('layout.footer')

@section('pageJs')
<script src="{{ asset('/js/fileDownloader.js') }}"></script>
@endsection
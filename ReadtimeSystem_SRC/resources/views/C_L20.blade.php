@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L20.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <defaultlist
  :pref-list='@json($prefList)'
  :search-param='@json($searchParam)'
  :keicho-type-list='@json($keichoTypeList)'
  :time-select-list='@json($timeSelectList)'
  :deadline-time-list='@json($deadlineTimeList)'
  ></defaultlist>

@endsection
 
@include('layout.footer')

@section('pageJs')
<script src="{{ asset('/js/fileDownloader.js') }}"></script>
@endsection

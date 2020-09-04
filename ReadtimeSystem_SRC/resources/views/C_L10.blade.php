@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L10.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <calendar-confirm
    :search-param='@json($searchParam)'
    :ym-list='@json($ymList)'
    :pref-list='@json($prefList)'
    :display-type-list='@json($displayTypeList)'
    :calendar-list='@json($calendarList)'
    :deadline-time-list='@json($deadlineTimeList)'
    :authinfo='@json(session('auth_info'))'
  ></calendar-confirm>
@endsection
 
@include('layout.footer')

@section('pageJs')
<script src="{{ asset('/js/fileDownloader.js') }}"></script>
@endsection

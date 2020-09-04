@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L21.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')

@section('content')
  <default
  :pref-list='@json($prefList)'
  :depo-info='@json($depoInfo)'
  :search-param='@json($searchParam)'
  :keicho-type-list='@json($keichoTypeList)'
  :time-select-list='@json($timeSelectList)'
  :deadline-time-list='@json($deadlineTimeList)'
  :error-msg-list='@json($errorMsgList)'></default>

@endsection
 
@include('layout.footer')

@section('pageJs')
<script src="{{ asset('/js/validation.js') }}"></script>
<script src="{{ asset('/js/fileDownloader.js') }}"></script>
@endsection

@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L01.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')

  {{-- ログイン表示 --}}
  <logininfo :authinfo='@json(session('auth_info'))'></logininfo>

  {{-- メッセージエリア --}}
  <messages 
    :authinfo='@json(session('auth_info'))'
    :unapprovedmsg="'{{ __('info.C_L01.unapproved', ['count' => $unapprovedCount]) }}'"
    :messages='@json($messages)'></messages>

  {{-- ボタンエリア --}}
  <top-menu
    :authinfo='@json(session('auth_info'))'
    :titles='@json($titles)'></top-menu>

@endsection
 
@include('layout.footer')

@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L11.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')

@section('content')
  <script type="text/x-template" id="change-reason-modal">
  <change-reason-modal></change-reason-modal>
  </script>
  <depo-request 
  :auth-info='@json($authInfo)'
  :month-list='@json($monthList)'
  :delivery-deadline-list='@json($deliveryDeadlineList)'
  :search-param='@json($searchParam)'
  :depo-info='@json($depoInfo)'
  :display-depo-cal-info='@json($displayDepoCalInfoModel)'
  :approvalstatus='@json($approvalStatus)'
  :confirmstatus='@json($confirmStatus)'
  :display-date-str='@json($displayDateStr)'
  :error-msg-list='@json($errorMsgList)'
  :list-back-url='@json($listBackUrl)'
  :depo-unchangeable-days='@json($depoUnchangeableDays)'
  ></depo-request>
@endsection
 
@include('layout.footer')

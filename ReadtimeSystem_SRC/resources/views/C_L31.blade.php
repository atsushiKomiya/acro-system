@extends('layout.frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L31.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
<irregular
:is-edit='@json($isEdit)'
:c-use-list='@json($cUseList)'
:time-select-list='@json($timeSelectList)'
:irregular='@json($irregular)'
:irregular-area-list='@json($irregularAreaList)'
:irregular-item-list='@json($irregularItemList)'
:irregular-depo-list='@json($irregularDepoList)'
:irregular-delivery-dayofweek-list='@json($irregularDeliveryDayofweekList)'
:irregular-order-dayofweek-list='@json($irregularOrderDayofweekList)'
></irregular>
@endsection
 
@include('layout.footer')
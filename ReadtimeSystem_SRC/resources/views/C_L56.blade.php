@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L56.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
  <messagelist
  :message-list='@json($messageList)'
  :depo-name-list='@json($depoNameList)'
  :item-category-large-cd-name-list='@json($itemCategoryLargeCdNameList)'
  :item-category-medium-cd-name-list='@json($itemCategoryMediumCdNameList)'
  :item-cd-name-list='@json($itemCdNameList)'
  :pref-cd-name-list='@json($prefCdNameList)'
  :siku-list='@json($sikuList)'
  :tyou-list='@json($tyouList)'
  :delivery-date='@json($deliveryDate)'
  :delivery-period='@json($deliveryPeriod)'
  :delivery-dayofweek-list='@json($deliveryDayofweekList)'></messagelist>
@endsection
 
@include('layout.footer')

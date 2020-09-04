@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L52.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
<itemlist
  :itemcategorylargelist='@json($itemCategoryLargeList->values())'
  :itemcategorymediumlist='@json($itemCategoryMediumList->values())'
  :viewitemlist='@json($viewItemList->values())'
  :islist='@json($isList)'></itemlist>
@endsection
@include('layout.footer')

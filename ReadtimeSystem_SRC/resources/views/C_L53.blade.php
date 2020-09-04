@extends('layout.child_frame')
 
@section('pageCss')
<link href="{{ asset('css/C_L53.css') }}" rel="stylesheet">
@endsection
 
@include('layout.header')
 
@section('content')
<itemmultiple
  :itemcategorylargelist='@json($itemCategoryLargeList->values())'
  :itemcategorymediumlist='@json($itemCategoryMediumList->values())'
  :viewitemlist='@json($viewItemList->values())'
  :islist='@json($isList)'></itemmultiple>
@endsection
@include('layout.footer')

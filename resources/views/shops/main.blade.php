@extends('layouts.main' ,[
'title' => "Shops: {$title}". (isset($subTitle) ? "{$subTitle}":''),
])
 
@section('title')
<h1 class="app-cmp-title">
    Shops:
    <span @class($titleClasses ?? [])>{{$title}}</span>
    @isset($subTitle)
    <span @class($subTitleClasses ?? [])>{{$subTitle}}</span>
    @endisset
</h1>
@endsection
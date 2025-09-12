@extends('layouts.main' ,[
'title' => "Categories: {$title}". (isset($subTitle) ? "{$subTitle}":''),
])

@section('title')
Categories:
<span @class($titleClasses ?? [])>{{$title}}</span>
@isset($subTitle)
<span @class($subTitleClasses ?? [])>{{$subTitle}}</span>
@endisset
@endsection
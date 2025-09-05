@extends('shops.main', [
    'title' => $shop->code,
])
 
@section('content')
    <form action="{{ route('shops.update', [
        'shop' => $shop->code,
    ]) }}" method="post">
        @csrf
 
        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" required  value="{{$shop->code}}"/>
 
            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" required  value="{{$shop->name}}" />
 
             <label for="app-inp-owner">Owner</label>
            <input type="text" id="app-inp-owner" name="owner"  required value="{{$shop->owner}}"/>
 
             <label for="app-inp-latitude">Latitude</label>
            <input id="app-inp-latitude" name="latitude" required value="{{$shop->latitude}}"/>
 
            <label for="app-inp-longitude">Longitude</label>
            <input id="app-inp-longitude" name="longitude" required value="{{$shop->longitude}}"/>
 
            <label for="app-inp-adress">Address</label>
            <textarea id="app-inp-address" name="address" cols="80" rows="10" required>{{ $shop->address }}</textarea>
 
         
        </div>
 
        <div class="app-cmp-form-actions">
            <button type="submit">Update</button>
        </div>
    </form>
@endsection
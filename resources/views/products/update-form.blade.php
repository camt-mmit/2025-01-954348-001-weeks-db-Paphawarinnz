@extends('products.main', [
    'title' => $product->code,
])

@section('content')
    <form action="{{ route('products.update', [
        'product' => $product->code,
    ]) }}" method="post">
        @csrf

        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" required  value="{{$product->code}}"/>

            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" required  value="{{$product->name}}" />

            <label for="app-inp-price">Price</label>
            <input type="number" id="app-inp-price" name="price" step="any" required  value="{{$product->price}}" />

            <label for="app-inp-description">Description</label>
            <textarea id="app-inp-description" name="description" required cols="80" rows="20"> {{$product->description}}"</textarea>
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit">Update</button>
        </div>
    </form>
@endsection
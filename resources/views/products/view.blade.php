@extends('products.main', [
    'title' => $product->code,
])
@section('header')
    <nav>
        <form action="{{ route('products.delete', [
            'product' => $product->code,
        ]) }}" method="post"
            id="app-form-delete">
            @csrf
        </form>

        <ul class="app-cmp-links">
            <li><a href="{{ route('products.view-shops', [
'product' => $product->code,
]) }}">View Shops</a></li>
            <li>
                <a
                    href="{{ route('products.update-form', [
                        'product' => $product->code,
                    ]) }}">Update</a>
            </li>
            <li class="app-cl-warn">
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
        </ul>
    </nav>
@endsection
@section('content')
    <dl class="app-cmp-data-detail">
        <dt>Code</dt>
        <dd>
            <span class="app-cl-code">{{ $product->code }}</span>
        </dd>

        <dt>Name</dt>
        <dd>
            {{ $product->name }}
        </dd>

        <dt>Price</dt>
        <dd>
            <span style="display: inline-block; width: 10ch;" class="app-cl-number">{{ $product->price }}</span>
        </dd>
    </dl>

    <pre>{{ $product->description }}</pre>
@endsection
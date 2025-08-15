@extends('products.main', [
    'title' => $product->name,
])

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
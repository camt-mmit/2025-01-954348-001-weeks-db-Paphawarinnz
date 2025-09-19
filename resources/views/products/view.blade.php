@extends('products.main', [
'title' => $product->code,
'titleClasses' => ['app-cl-code'],
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
    <dd class="app-cl-code">
        {{ $product->code }}
    </dd>

    <dt>Name</dt>
    <dd>
        {{ $product->name }}
    </dd>
   <dt>Category</dt>
    <dd >
        @if ($product->category)
            <a href="{{ route('categories.view', ['category' => $product->category->code]) }}">
              [<span class="app-cl-code">{{ $product->category->code }}</span>] 
            </a>{{ $product->category->name }}
        @else
            N/A
        @endif
    </dd>

    <dt>Price</dt>
    <dd>
         <span class="app-cl-number">{{ number_format($product->price, 2) }}</span>
    </dd>
</dl>

<pre>{{ $product->description }}</pre>
@endsection
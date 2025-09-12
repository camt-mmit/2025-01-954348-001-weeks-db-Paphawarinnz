@extends('shops.main', [
'title' => $shop->code,
])
@section('header')
    <nav>
        <form action="{{ route('shops.delete', [
            'shop' => $shop->code,
        ]) }}" method="post"
            id="app-form-delete">
            @csrf
        </form>

        <ul class="app-cmp-links">
                    <li><a href="{{ route('shops.view-products', [
'shop' => $shop->code,
]) }}">View Products</a></li>
            <li>
                <a
                    href="{{ route('shops.update-form', [
                        'shop' => $shop->code,
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
        <span class="app-cl-code">{{ $shop->code }}</span>
    </dd>

    <dt>Name</dt>
    <dd>
        {{ $shop->name }}
    </dd>
    <dt>Owner</dt>
    <dd>
        {{ $shop->owner }}
    </dd>

    <dt>Location</dt>
    <dd>
        {{ $shop->latitude }}, {{ $shop->longitude }}
    </dd>
    <dt>Address</dt>
<dd>
{!! nl2br($shop->address) !!}
</dd>
</dl>

@endsection
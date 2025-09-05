@extends('shops.main' , [
'title' => 'List' ,
])

@section('header')
<search>
    <form action="{{ route('shops.list') }}" method="get" class="app-cmp-search-form">
        <div class="app-cmp-form-detail">
            <label for="app-criteria-term">Search</label>
            <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />

        </div>

        <div class="app-cmp-form-actions">
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('shops.list') }}">
                <button type="button" class="accent">X</button>
            </a>
        </div>
    </form>
</search>

<div class="app-cmp-links-bar">
    <nav>
        <ul class="app-cmp-links">
            <li>
                <a href="{{ route('shops.create-form') }}">New Shop</a>
            </li>
        </ul>
    </nav>

    {{ $shops->withQueryString()->links() }}
</div>
@endsection

@section('content')
<table class="app-cmp-data-list">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Owner</th>
        </tr>
    </thead>

    <tbody>
        @foreach($shops as $shop)
        <tr>
            <td>
                <a href="{{ route('shops.view', [
                            'shop' => $shop->code,
                        ]) }}"
                    class="app-cl-code">
                    {{ $shop->code }}
                </a>
            </td>
            <td>{{ $shop->name }}</td>
            <td>{{ $shop->owner }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
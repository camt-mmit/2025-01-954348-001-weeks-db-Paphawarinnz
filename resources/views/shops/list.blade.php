@extends('shops.main', [
    'title' => 'List',
    'mainClasses' => ['app-ly-max-width'],
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
    <div>
        {{ $shops->withQueryString()->links() }}
    </div>
</div>
@endsection

@section('content')
    <table class="app-cmp-data-list">
        <colgroup>
            <col style="width: 5ch;" />
        </colgroup>

        <thead>
            <tr>
                <th>Code</th>
            <th>Name</th>
            <th>Owner</th>
              <th>No. of Products</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($shops as $shop)
<tr>
    <td>
        <a href="{{ route('shops.view',[
                            'shop' => $shop->code,
                        ]) }}"
                        class="app-cl-code">
            {{ $shop->code}}
        </td>
        </a>
      <td>{{ $shop->name}}</td>
       <td>{{ $shop->owner}}</td>
       <td class="app-cl-number">{{number_format($shop->products_count, 0) }}</td>
</tr>
@endforeach
        </tbody>
    </table>
@endsection
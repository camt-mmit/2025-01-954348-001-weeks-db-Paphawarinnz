@extends('products.main', [
    'mainClasses' => ['app-ly-max-width'],
'title' => $product->code ,
'titleclasses' => ['app-cl-code'],
'subTitle'  => 'Shops',
])
 
@section('header')
<search>
    <form action="{{ route('products.view-shops', ['product' => $product->code,]) }}" method="get" class="app-cmp-search-form">
        {{-- ... Other form controls --}}
       
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />
 
       
            </div>
 
            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('products.list') }}">
                    <button type="button" class="accent">X</button>
                </a>
            </div>
        </form>
</search>
 
<div class="app-cmp-links-bar">
  <nav>
<ul class="app-cmp-links">
{{-- Add back link to product-view --}}
<li><a href="{{ route('products.view', [
'product' => $product->code,
]) }}">&lt; Back</a></li>
</ul>
{{ $shops->withQueryString()->links() }}
</nav>
 
    {{ $shops->withQueryString()->links() }}
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
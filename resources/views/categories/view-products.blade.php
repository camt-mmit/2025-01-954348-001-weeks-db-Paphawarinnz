@extends('categories.main', [
'mainClasses' => ['app-ly-max-width'],
'title' => "$category->code ",
'titleclasses'=> ['app-cl-code'],
'subTitle'=> 'Products',
])
 
@section('header')
    <search>
        <form action="{{ route('categories.view-products' , ['category' => $category->code,])  }}" method="get" class="app-cmp-search-form">
       
 
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />
 
                <label for="app-criteria-min-price">Min Price</label>
                <input type="number" id="app-criteria-min-price" name="minPrice" value="{{ $criteria['minPrice'] ?? ''}}"
                    step="any" />
 
                <label for="app-criteria-max-price">Max Price</label>
                <input type="number" id="app-criteria-max-price" name="maxPrice" value="{{ $criteria['maxPrice'] ?? '' }}"
                    step="any" />
            </div>
 
            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('categories.list') }}">
                    <button type="button" class="accent">X</button>
                </a>
            </div>
        </form>
    </search>
 
    <div class="app-cmp-links-bar">
    <nav>
        <ul class="app-cmp-links">
            <li><a href="{{ route('categories.view', ['category' => $category->code,]) }}">&lt; Back</a></li>
        </ul>
    </nav>
 
    {{ $products->withQueryString()->links() }}
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
                <th>Price</th>
                <th>No. of Shops</th>
            </tr>
        </thead>
 
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.view', [
                            'product' => $product->code,
                        ]) }}"
                            class="app-cl-code">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td class="app-cl-number">{{ number_format($product->price, 2) }}</td>
                     
                     <td class="app-cl-number">{{number_format($product->shops_count, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
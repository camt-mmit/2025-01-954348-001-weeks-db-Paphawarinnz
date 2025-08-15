@extends('products.main' , [
'title' => 'List' ,
])

@section('content')
<table class="app-cmp-data-list">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
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
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
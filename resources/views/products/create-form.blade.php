@extends('products.main', [
    'title' => 'Create',
])

@section('content')
    <form action="{{ route('products.create') }}" method="post">
        @csrf

        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" required />

            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" required />

            <label for="app-inp-price">Price</label>
            <input type="number" id="app-inp-price" name="price" step="any" required />

            <label for="app-inp-description">Description</label>
            <textarea id="app-inp-description" name="description" cols="80" rows="20" required></textarea>
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit">Create</button>
        </div>
    </form>
@endsection
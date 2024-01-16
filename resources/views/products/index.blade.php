<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Products</h1>

    <a href="{{ route('products.create') }}">Create Product</a>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Categories</th>
            <th>Attributes</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>
                    @foreach ($product->categories as $category)
                        {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </td>
                <td>
                    @foreach ($product->attributes as $attribute)
                        {{ $attribute->name }}: {{ $attribute->pivot->value }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('products.edit', $product) }}">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

<!-- resources/views/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Product - {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" value="{{ $product->name }}" required>

        <label for="categories">Select Categories:</label>
        <select name="categories[]" id="categories" multiple required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="attributes">Select Attributes:</label>
        <select name="attributes[]" id="attributes" multiple required>
            @foreach ($attributes as $attribute)
                <option value="{{ $attribute->id }}" {{ $product->attributes->contains($attribute->id) ? 'selected' : '' }}>
                    {{ $attribute->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update Product</button>
    </form>
@endsection

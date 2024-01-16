<!-- resources/views/products/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="description">Product Description:</label>
        <textarea name="description"></textarea>

        <label for="categories">Select Categories:</label>
        <select name="categories[]" multiple required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="attributes">Select Attributes:</label>
        @foreach ($attributes as $attribute)
            <div>
                <label for="attribute_{{ $attribute->id }}">{{ $attribute->name }}:</label>
                @if ($attribute->type === 'range')
                    <input type="text" name="attributes[{{ $attribute->id }}][values]" placeholder="Enter range values">
                @elseif ($attribute->type === 'select')
                    <select name="attributes[{{ $attribute->id }}][values][]" multiple required>
                        @foreach ($attribute->values as $value)
                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach

        <button type="submit">Create Product</button>
    </form>
@endsection

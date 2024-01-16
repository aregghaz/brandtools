<!-- resources/views/categories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Categories</h1>

    <a href="{{ route('categories.create') }}">Create Category</a>

    <ul>
        @foreach ($categories as $category)
            <li>
                {{ $category->title }}
                <a href="{{ route('categories.edit', $category) }}">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- resources/views/categories/index.blade.php -->


{{--    <h1>Category: {{ $category->name }}</h1>--}}

{{--    <form action="{{ route('categories.filter', $category) }}" method="GET">--}}
{{--        @foreach ($attributes as $attribute)--}}
{{--            <label for="attribute_{{ $attribute->id }}">{{ $attribute->name }}:</label>--}}

{{--            @if ($attribute->type === 'range')--}}
{{--                <input type="text" name="attributes[{{ $attribute->id }}][min]" placeholder="Min">--}}
{{--                <input type="text" name="attributes[{{ $attribute->id }}][max]" placeholder="Max">--}}
{{--            @elseif ($attribute->type === 'select')--}}
{{--                <select name="attributes[{{ $attribute->id }}][]">--}}
{{--                    @foreach ($attribute->values as $value)--}}
{{--                        <option value="{{ $value }}">{{ $value }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            @endif--}}
{{--        @endforeach--}}

{{--        <button type="submit">Apply Filter</button>--}}
{{--    </form>--}}

{{--    <h2>Filtered Products</h2>--}}

{{--    <ul>--}}
{{--        @foreach ($products as $product)--}}
{{--            <li>{{ $product->name }}</li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
@endsection



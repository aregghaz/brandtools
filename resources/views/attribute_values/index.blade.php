<!-- resources/views/attribute_values/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Attribute Values</h1>

    <a href="{{ route('attribute_values.create') }}">Create Attribute Value</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Value</th>
            <th>Attribute</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attributeValues as $attributeValue)
            <tr>
                <td>{{ $attributeValue->id }}</td>
                <td>{{ $attributeValue->value }}</td>
                <td>{{ $attributeValue->attribute->name }}</td>
                <td>{{ ucfirst($attributeValue->type) }}</td>
                <td>
                    <a href="{{ route('attribute_values.edit', $attributeValue) }}">Edit</a>
                    <form action="{{ route('attribute_values.destroy', $attributeValue) }}" method="POST">
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

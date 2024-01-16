<!-- resources/views/attributes/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Attribute: {{ $attribute->name }}</h1>

    <form action="{{ route('attributes.update', $attribute) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Attribute Name:</label>
        <input type="text" name="name" value="{{ $attribute->name }}" required>

        <label for="type">Attribute Type:</label>
        <select name="type" required>
            <option value="range" {{ $attribute->type === 'range' ? 'selected' : '' }}>Range</option>
            <option value="select" {{ $attribute->type === 'select' ? 'selected' : '' }}>Select</option>
        </select>

        <button type="submit">Update Attribute</button>
    </form>
@endsection

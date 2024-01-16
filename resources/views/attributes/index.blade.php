<!-- resources/views/attributes/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Attributes</h1>

    <ul>
        @foreach ($attributes as $attribute)
            <li>{{ $attribute->name }} ({{ $attribute->type }})</li>
        @endforeach
    </ul>

    <a href="{{ route('attributes.create') }}">Create Attribute</a>
@endsection

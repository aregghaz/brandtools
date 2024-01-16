<!-- resources/views/attribute_values/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Attribute Value</h1>

    <form action="{{ route('attribute_values.store') }}" method="POST">
        @csrf

        <label for="value">Attribute Value:</label>
        <input type="text" name="value" required>

        <label for="attribute_id">Attribute:</label>
        <select name="attribute_id" required>
            @foreach ($attributes as $attribute)
                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
            @endforeach
        </select>

        <label for="type">Attribute Type:</label>
        <select name="type" required>
            <option value="range">Range</option>
            <option value="select">Select</option>
        </select>

        <div id="rangeValues" style="display:none;">
            <label for="range_values">Range Values:</label>
            <input type="text" name="range_values" placeholder="Enter range values">
        </div>

        <div id="selectValues" style="display:none;">
            <label for="select_values">Select Values:</label>
            <select name="select_values[]" multiple>
                <!-- Options will be dynamically populated using JavaScript based on the selected attribute -->
            </select>
        </div>

        <button type="submit">Create Attribute Value</button>
    </form>

    <script>
        // JavaScript to toggle display of range and select input based on attribute type
        document.addEventListener('DOMContentLoaded', function () {
            const attributeTypeSelect = document.querySelector('select[name="type"]');
            const rangeValuesDiv = document.getElementById('rangeValues');
            const selectValuesDiv = document.getElementById('selectValues');

            attributeTypeSelect.addEventListener('change', function () {
                const selectedType = this.value;

                // Hide both divs initially
                rangeValuesDiv.style.display = 'none';
                selectValuesDiv.style.display = 'none';

                // Show the div based on the selected attribute type
                if (selectedType === 'range') {
                    rangeValuesDiv.style.display = 'block';
                } else if (selectedType === 'select') {
                    selectValuesDiv.style.display = 'block';
                }
            });
        });
    </script>
@endsection

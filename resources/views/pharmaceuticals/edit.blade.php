@extends('layouts.app')
@section('title', 'Edit Drug')
@section('topbar-actions')
    <a href="{{ route('pharmaceuticals.index') }}" class="btn">Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px; margin: 2rem auto;">
    <div class="card-title">Edit drug #{{ $pharmaceutical->drug_no }}</div>
    <form method="POST" action="{{ route('pharmaceuticals.update', $pharmaceutical->drug_no) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Drug name</label>
                <input type="text" name="drug_name" value="{{ old('drug_name', $pharmaceutical->drug_name) }}" required>
            </div>
            <div class="form-group">
                <label>Dosage</label>
                <input type="text" name="dosage" value="{{ old('dosage', $pharmaceutical->dosage) }}" required>
            </div>
            <div class="form-group">
                <label>Method of admin</label>
                <input type="text" name="method_of_admin" value="{{ old('method_of_admin', $pharmaceutical->method_of_admin) }}" required>
            </div>
            <div class="form-group">
                <label>Quantity in stock</label>
                <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $pharmaceutical->quantity_in_stock) }}" required>
            </div>
            <div class="form-group">
                <label>Reorder level</label>
                <input type="number" name="reorder_level" value="{{ old('reorder_level', $pharmaceutical->reorder_level) }}" required>
            </div>
            <div class="form-group">
                <label>Cost per unit</label>
                <input type="number" step="0.01" name="cost_per_unit" value="{{ old('cost_per_unit', $pharmaceutical->cost_per_unit) }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description">{{ old('description', $pharmaceutical->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

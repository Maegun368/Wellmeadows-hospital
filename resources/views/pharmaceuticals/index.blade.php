@extends('layouts.app')
@section('title', 'Pharmaceuticals')

@section('content')
<div style="padding:14px 24px; display:flex; gap:8px;">
    <a href="{{ route('appointments.index') }}" class="btn">← Back to Appointments</a>
    <a href="{{ route('pharmaceuticals.create') }}" class="btn btn-primary">+ Add Drug</a>
</div>
<div class="card">
    <table>
        <thead>
            <tr><th>Drug No</th><th>Name</th><th>Dosage</th><th>Method</th><th>Stock</th><th>Reorder</th><th>Cost/Unit</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($pharmaceuticals as $drug)
            <tr>
                <td>{{ $drug->drug_no }}</td>
                <td>{{ $drug->drug_name }}</td>
                <td>{{ $drug->dosage }}</td>
                <td>{{ $drug->method_of_admin }}</td>
                <td>
                    @if($drug->quantity_in_stock <= $drug->reorder_level)
                        <span class="badge badge-red">{{ $drug->quantity_in_stock }} ⚠</span>
                    @else
                        <span class="badge badge-green">{{ $drug->quantity_in_stock }}</span>
                    @endif
                </td>
                <td>{{ $drug->reorder_level }}</td>
                <td>₱{{ number_format($drug->cost_per_unit, 2) }}</td>
                <td style="display:flex; gap:6px;">
    <a href="{{ route('pharmaceuticals.edit', $drug->drug_no) }}" class="btn">Edit</a>
    <form method="POST" action="{{ route('pharmaceuticals.destroy', $drug->drug_no) }}" style="margin:0"
          onsubmit="return confirm('Delete this drug?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#718096;padding:2rem">No pharmaceuticals found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $pharmaceuticals->links() }}</div>
</div>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assign bed
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('error'))
                    <div class="mb-4 text-red-600 font-semibold text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bed-allocations.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                        <select name="patient_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Select patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>
                                    {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ward</label>
                        <select name="ward_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Select ward —</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->ward_id }}" @selected(old('ward_id') == $ward->ward_id)>
                                    {{ $ward->ward_name }} — {{ $ward->location }} ({{ $ward->total_beds }} beds)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bed number</label>
                        <input type="number" name="bed_number" min="1" value="{{ old('bed_number') }}" required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected leave (optional)</label>
                        <input type="date" name="date_expected_leave" value="{{ old('date_expected_leave') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-green-700">
                            Save assignment
                        </button>
                        <a href="{{ route('bed-allocations.index') }}"
                           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

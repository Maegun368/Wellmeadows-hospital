<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit bed allocation
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

                <p class="text-sm text-gray-600 mb-4">
                    Patient:
                    <strong>
                        @if($bedAllocation->patient)
                            {{ $bedAllocation->patient->first_name }} {{ $bedAllocation->patient->last_name }}
                            (ID {{ $bedAllocation->patient_id }})
                        @else
                            ID {{ $bedAllocation->patient_id }}
                        @endif
                    </strong>
                </p>

                <form method="POST" action="{{ route('bed-allocations.update', $bedAllocation) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ward</label>
                        <select name="ward_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($wards as $ward)
                                <option value="{{ $ward->ward_id }}" @selected(old('ward_id', $bedAllocation->ward_id) == $ward->ward_id)>
                                    {{ $ward->ward_name }} — {{ $ward->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bed number</label>
                        <input type="number" name="bed_number" min="1"
                               value="{{ old('bed_number', $bedAllocation->bed_number) }}" required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Expected leave (optional)</label>
                        <input type="date" name="date_expected_leave"
                               value="{{ old('date_expected_leave', optional($bedAllocation->date_expected_leave)->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('bed-allocations.index') }}"
                           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-300 inline-flex items-center">
                            Cancel
                        </a>
                    </div>
                </form>

                @if(!$bedAllocation->actual_leave_date)
                    <form method="POST" action="{{ route('bed-allocations.discharge', $bedAllocation) }}"
                          class="mt-8 pt-6 border-t border-gray-200"
                          onsubmit="return confirm('Discharge this patient from this bed?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-amber-600">
                            Discharge patient
                        </button>
                    </form>
                @endif

                @if($bedAllocation->actual_leave_date)
                    <form method="POST" action="{{ route('bed-allocations.destroy', $bedAllocation) }}"
                          class="mt-6"
                          onsubmit="return confirm('Delete this allocation record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm font-semibold hover:underline">
                            Delete record
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

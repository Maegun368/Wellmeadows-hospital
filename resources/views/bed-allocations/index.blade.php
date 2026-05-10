<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bed Allocations
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 text-red-600 font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between mb-4">

                    <form method="GET" class="flex gap-2">

                        <input type="text"
                               name="search"
                               value="{{ $search ?? '' }}"
                               placeholder="Search patient..."
                               class="border rounded px-3 py-2 text-sm">

                        <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                            Search
                        </button>

                    </form>

                    <a href="{{ route('bed-allocations.create') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded text-sm">

                        + Assign Bed

                    </a>

                </div>

                <table class="w-full border text-sm">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="p-3 border">#</th>
                            <th class="p-3 border">Patient</th>
                            <th class="p-3 border">Ward</th>
                            <th class="p-3 border">Bed Number</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Expected Leave</th>
                            <th class="p-3 border">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($allocations as $allocation)

                        <tr class="hover:bg-gray-50">

                            <td class="p-3 border">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-3 border">
                                @if($allocation->patient)
                                    <span class="font-medium text-gray-900">
                                        {{ $allocation->patient->first_name }} {{ $allocation->patient->last_name }}
                                    </span>
                                    <span class="block text-xs text-gray-500">ID {{ $allocation->patient_id }}</span>
                                @else
                                    ID {{ $allocation->patient_id }}
                                @endif
                            </td>

                            <td class="p-3 border">
                                {{ $allocation->ward->ward_name }}
                            </td>

                            <td class="p-3 border">
                                Bed {{ $allocation->bed_number }}
                            </td>

                            <td class="p-3 border">

                                @if($allocation->actual_leave_date)

                                    <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs">
                                        Discharged
                                    </span>

                                @else

                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                        Occupied
                                    </span>

                                @endif

                            </td>

                            <td class="p-3 border">
                                {{ $allocation->date_expected_leave?->format('Y-m-d') ?? 'N/A' }}
                            </td>

                            <td class="p-3 border space-x-2 whitespace-nowrap">

                                <a href="{{ route('bed-allocations.edit', $allocation) }}"
                                   class="bg-yellow-400 text-white px-3 py-1 rounded inline-block">

                                    Edit

                                </a>

                                @if(!$allocation->actual_leave_date)
                                    <form action="{{ route('bed-allocations.discharge', $allocation) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Discharge this patient?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-amber-500 text-white px-3 py-1 rounded text-xs">
                                            Discharge
                                        </button>
                                    </form>
                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7"
                                class="text-center p-4 text-gray-500">

                                No bed allocations found.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $allocations->links() }}
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
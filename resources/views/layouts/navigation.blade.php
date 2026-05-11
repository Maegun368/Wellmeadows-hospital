<nav class="bg-[#163B65] text-white w-64 min-h-screen fixed left-0 top-0">

    <div class="p-6 text-2xl font-bold border-b border-blue-800">
        Wellmeadows
    </div>

    <div class="flex flex-col mt-4">

        <a href="{{ route('dashboard') }}"
           class="px-6 py-4 hover:bg-blue-800">
            Dashboard
        </a>

        <a href="{{ route('patients.index') }}"
           class="px-6 py-4 hover:bg-blue-800">
            Patients
        </a>

        <a href="{{ route('appointments.index') }}"
           class="px-6 py-4 hover:bg-blue-800">
            Appointments
        </a>

        <a href="{{ route('staff.index') }}"
           class="px-6 py-4 hover:bg-blue-800">
            Staff
        </a>

        <a href="{{ route('wards.index') }}"
           class="px-6 py-4 hover:bg-blue-800">
            Ward & Bed Management
        </a>

    </div>

</nav>
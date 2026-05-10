<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Placeholder: wire views and models when requisitions are implemented.
 */
class WardRequisitionController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard')
            ->with('warning', 'Ward requisitions are not implemented yet.');
    }

    public function create()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        return $this->index();
    }

    public function show(string $id)
    {
        return $this->index();
    }

    public function edit(string $id)
    {
        return $this->index();
    }

    public function update(Request $request, string $id)
    {
        return $this->index();
    }

    public function destroy(string $id)
    {
        return $this->index();
    }
}

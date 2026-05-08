<?php

namespace App\Http\Controllers;

use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class PharmaceuticalController extends Controller
{
    public function index()
    {
        $pharmaceuticals = Pharmaceutical::paginate(10);
        return view('pharmaceuticals.index', compact('pharmaceuticals'));
    }

    public function create()
    {
        return view('pharmaceuticals.create');
    }

    public function store(Request $request)
    {
        Pharmaceutical::create($request->validate([
            'supplier_no'       => 'nullable|integer',
            'drug_name'         => 'required|string',
            'description'       => 'nullable|string',
            'dosage'            => 'required|string',
            'method_of_admin'   => 'required|string',
            'quantity_in_stock' => 'required|integer',
            'reorder_level'     => 'required|integer',
            'cost_per_unit'     => 'required|numeric',
        ]));

        return redirect()->route('pharmaceuticals.index')->with('success', 'Drug added.');
    }

    public function edit($id)
    {
        $pharmaceutical = Pharmaceutical::findOrFail($id);
        return view('pharmaceuticals.edit', compact('pharmaceutical'));
    }

    public function update(Request $request, $id)
    {
        $pharmaceutical = Pharmaceutical::findOrFail($id);

        $pharmaceutical->update($request->validate([
            'supplier_no'       => 'nullable|integer',
            'drug_name'         => 'required|string',
            'description'       => 'nullable|string',
            'dosage'            => 'required|string',
            'method_of_admin'   => 'required|string',
            'quantity_in_stock' => 'required|integer',
            'reorder_level'     => 'required|integer',
            'cost_per_unit'     => 'required|numeric',
        ]));

        return redirect()->route('pharmaceuticals.index')->with('success', 'Updated.');
    }

    public function destroy($id)
    {
        Pharmaceutical::findOrFail($id)->delete();
        return redirect()->route('pharmaceuticals.index')->with('success', 'Drug deleted.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\QurbanEvent;
use App\Models\QurbanOffering;
use Illuminate\Http\Request;

class QurbanOfferingController extends Controller
{
    public function create(QurbanEvent $qurban)
    {
        return view('qurban.offerings.create', compact('qurban'));
    }

    public function store(Request $request, QurbanEvent $qurban)
    {
        $this->validate($request, [
            'type' => 'required|string|max:60',
            'name' => 'required|string|max:60',
            'price' => 'required|numeric|min:0',
        ]);

        $qurban->offerings()->create($request->all());

        return redirect()->route('qurban.show', $qurban)->with('success', __('qurban_offering.created'));
    }

    public function edit(QurbanEvent $qurban, QurbanOffering $offering)
    {
        return view('qurban.offerings.edit', compact('qurban', 'offering'));
    }

    public function update(Request $request, QurbanEvent $qurban, QurbanOffering $offering)
    {
        $this->validate($request, [
            'type' => 'required|string|max:60',
            'name' => 'required|string|max:60',
            'price' => 'required|numeric|min:0',
        ]);

        $offering->update($request->all());

        return redirect()->route('qurban.show', $qurban)->with('success', __('qurban_offering.updated'));
    }

    public function destroy(QurbanEvent $qurban, QurbanOffering $offering)
    {
        $this->validate(request(), [
            'offering_id' => 'required',
        ]);

        if (request('offering_id') == $offering->id && $offering->delete()) {
            return redirect()->route('qurban.show', $qurban)->with('success', __('qurban_offering.deleted'));
        }

        return back()->with('error', __('qurban_offering.undeleted'));
    }
}


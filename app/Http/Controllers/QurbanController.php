<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QurbanEvent;

use Illuminate\Http\Request;

class QurbanController extends Controller
{
    public function index()
    {
        $qurbanEvents = QurbanEvent::latest()->paginate(25);

        return view('qurban.index', compact('qurbanEvents'));
    }

    public function create()
    {
        return view('qurban.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:60',
            'year_hijri' => 'required|digits:4',
            'registration_deadline' => 'required|date',
        ]);

        QurbanEvent::create($request->all());

        return redirect()->route('qurban.index')->with('success', __('qurban.created'));
    }

    public function show(QurbanEvent $qurban)
    {
        $qurban->load(['offerings.participants']);

        return view('qurban.show', compact('qurban'));
    }

    public function edit(QurbanEvent $qurban)
    {
        return view('qurban.edit', compact('qurban'));
    }

    public function update(Request $request, QurbanEvent $qurban)
    {
        $this->validate($request, [
            'name' => 'required|string|max:60',
            'year_hijri' => 'required|digits:4',
            'registration_deadline' => 'required|date',
        ]);

        $qurban->update($request->all());

        return redirect()->route('qurban.show', $qurban)->with('success', __('qurban.updated'));
    }

    public function destroy(QurbanEvent $qurban)
    {
        $this->validate(request(), [
            'qurban_id' => 'required',
        ]);

        if (request('qurban_id') == $qurban->id && $qurban->delete()) {
            return redirect()->route('qurban.index')->with('success', __('qurban.deleted'));
        }

        return back()->with('error', __('qurban.undeleted'));
    }
}

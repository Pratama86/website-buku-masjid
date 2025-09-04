<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\QurbanEvent;
use App\Models\QurbanParticipant;
use Illuminate\Support\Facades\Storage;

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
        Log::info('Qurban Event Store - Request Data:', ['request' => $request->all()]);
        Log::info('Qurban Event Store - Has File Image (before if):', ['hasFile' => $request->hasFile('image')]);
        $this->validate($request, [
            'name' => 'required|string|max:60',
            'year_hijri' => 'required|digits:4',
            'registration_deadline' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $newQurbanEvent = $request->except('image');
        Log::info('Qurban Event Store - Has File Image:', ['hasFile' => $request->hasFile('image')]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('qurban_events', 'public');
            $newQurbanEvent['image_path'] = $path;
            Log::info('Qurban Event Store - Path:', ['path' => $path]);
            Log::info('Qurban Event Store - Data:', ['data' => $newQurbanEvent]);
        }

        QurbanEvent::create($newQurbanEvent);

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
        Log::info('Qurban Event Update - Request Data:', ['request' => $request->all()]);
        Log::info('Qurban Event Update - Has File Image (before if):', ['hasFile' => $request->hasFile('image')]);
        $this->validate($request, [
            'name' => 'required|string|max:60',
            'year_hijri' => 'required|digits:4',
            'registration_deadline' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $updatedQurbanEvent = $request->except('image');
        Log::info('Qurban Event Update - Has File Image:', ['hasFile' => $request->hasFile('image')]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('qurban_events', 'public');
            $updatedQurbanEvent['image_path'] = $path;
            Log::info('Qurban Event Update - Path:', ['path' => $path]);
            Log::info('Qurban Event Update - Data:', ['data' => $updatedQurbanEvent]);
        }

        $qurban->update($updatedQurbanEvent);

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

    public function participants(QurbanEvent $qurban)
    {
        $qurban->load('offerings.participants.offering');

        return view('qurban.participants', compact('qurban'));
    }

    public function destroyParticipant(QurbanEvent $qurban, QurbanParticipant $participant)
    {
        $this->authorize('delete', $participant);

        if ($participant->photo_path) {
            Storage::disk('public')->delete($participant->photo_path);
        }

        $participant->delete();

        return redirect()->route('qurban.participants', $qurban)->with('success', __('qurban_participant.deleted'));
    }
}

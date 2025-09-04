<?php

namespace App\Http\Controllers;

use App\Models\QurbanEvent;
use App\Models\QurbanParticipant;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QurbanRegistrationController extends Controller
{
    public function create(QurbanEvent $qurban)
    {
        $qurban->load('offerings.participants');
        return view('qurban.register', compact('qurban'));
    }

    public function store(Request $request, QurbanEvent $qurban)
    {
        $this->validate($request, [
            'qurban_offering_id' => 'required|exists:qurban_offerings,id',
            'name' => 'required|string|max:60',
            'phone_number' => 'required|string|max:20',
            'photo' => 'nullable|string',
        ]);

        $offering = $qurban->offerings()->withCount('participants')->findOrFail($request->get('qurban_offering_id'));

        if ($offering->participant_limit && $offering->participants_count >= $offering->participant_limit) {
            return redirect()->back()->with('error', 'Maaf, kuota untuk '.$offering->name.' sudah penuh.');
        }

        $participantData = $request->only('name', 'phone_number');

        if ($request->filled('photo')) {
            Log::info('Photo data received.');
            $imageData = $request->get('photo');
            $image = str_replace('data:image/jpeg;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'qurban_participants/'.Str::random(40) . '.'.'jpg';
            Storage::disk('public')->makeDirectory('qurban_participants');
            $result = Storage::disk('public')->put($imageName, base64_decode($image));
            Log::info('Storage put result:', ['result' => $result]);
            Log::info('Storage path:', ['path' => Storage::disk('public')->path('')]);
            $participantData['photo_path'] = $imageName;
        } else {
            Log::info('No photo data received.');
        }

        $transaction = new Transaction;
        $transaction->date = today()->format('Y-m-d');
        $transaction->in_out = 1; // Pemasukan
        $transaction->amount = $offering->price;
        $transaction->description = 'Pendaftaran Qurban: '.$offering->name.' a/n '.$request->get('name');
        $transaction->book_id = config('masjid.default_book_id');
        $transaction->category_id = config('masjid.qurban_category_id');
        $transaction->creator_id = auth()->id() ?? 1; // Default to user 1 if not logged in
        $transaction->save();

        $participantData['qurban_offering_id'] = $offering->id;
        $participantData['transaction_id'] = $transaction->id;
        $participantData['status'] = 'pending';

        QurbanParticipant::create($participantData);

        return redirect()->route('qurban.register', $qurban)->with('success', 'Pendaftaran Anda telah berhasil.');
    }
}

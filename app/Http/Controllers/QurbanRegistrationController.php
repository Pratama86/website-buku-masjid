<?php

namespace App\Http\Controllers;

use App\Models\QurbanEvent;
use App\Models\QurbanParticipant;
use App\Transaction;
use Illuminate\Http\Request;

class QurbanRegistrationController extends Controller
{
    public function create(QurbanEvent $qurban)
    {
        $qurban->load('offerings');
        return view('qurban.register', compact('qurban'));
    }

    public function store(Request $request, QurbanEvent $qurban)
    {
        $this->validate($request, [
            'qurban_offering_id' => 'required|exists:qurban_offerings,id',
            'name' => 'required|string|max:60',
            'phone_number' => 'required|string|max:20',
        ]);

        $offering = $qurban->offerings()->findOrFail($request->get('qurban_offering_id'));

        $transaction = new Transaction;
        $transaction->date = today()->format('Y-m-d');
        $transaction->in_out = 1; // Pemasukan
        $transaction->amount = $offering->price;
        $transaction->description = 'Pendaftaran Qurban: '.$offering->name.' a/n '.$request->get('name');
        $transaction->book_id = config('masjid.default_book_id');
        $transaction->category_id = config('masjid.qurban_category_id');
        $transaction->creator_id = auth()->id() ?? 1; // Default to user 1 if not logged in
        $transaction->save();

        QurbanParticipant::create([
            'qurban_offering_id' => $offering->id,
            'transaction_id' => $transaction->id,
            'name' => $request->get('name'),
            'phone_number' => $request->get('phone_number'),
            'status' => 'registered',
        ]);

        return redirect()->route('qurban.register', $qurban)->with('success', 'Pendaftaran Anda telah berhasil.');
    }
}

<?php

namespace App\Models;

use App\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QurbanParticipant extends Model
{
    use HasFactory;

    protected $fillable = ['qurban_offering_id', 'transaction_id', 'name', 'phone_number', 'status', 'photo_path'];

    public function offering(): BelongsTo
    {
        return $this->belongsTo(QurbanOffering::class, 'qurban_offering_id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
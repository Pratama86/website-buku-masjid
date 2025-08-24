<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QurbanOffering extends Model
{
    use HasFactory;

    protected $fillable = ['qurban_event_id', 'type', 'name', 'price'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(QurbanEvent::class, 'qurban_event_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(QurbanParticipant::class);
    }
}
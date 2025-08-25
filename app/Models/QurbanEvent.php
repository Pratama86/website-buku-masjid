<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QurbanEvent extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'year_hijri', 'registration_deadline', 'image_path'];

    public function offerings(): HasMany
    {
        return $this->hasMany(QurbanOffering::class);
    }
}
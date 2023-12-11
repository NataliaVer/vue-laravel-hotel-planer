<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTranslations extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'amenities', 'price', 'count_one_bed', 'count_two_bed', 'count_rooms', 'room_id', 'lang_code'];

    public function language() {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}

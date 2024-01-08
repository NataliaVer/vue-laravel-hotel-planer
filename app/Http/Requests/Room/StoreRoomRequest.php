<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'price' => 'required|integer',
            'description' => 'required',
            'amenities' => '',
            'count_bed' => 'required|integer',
            'count_seats_in_bed' => 'required|integer',
            'count_rooms' => 'required|integer',
            'room_photos' => 'required',
            'hotel_id' => '',
            'lang_code' => '',
            ];
    }
}

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
            'price' => 'required',
            'description' => 'required',
            'amenities' => '',
            'count_one_bed' => '',
            'count_two_bed' => '',
            'count_rooms' => 'required',
            'room_photos' => 'required',
            'hotel_id' => ''
            ];
    }
}

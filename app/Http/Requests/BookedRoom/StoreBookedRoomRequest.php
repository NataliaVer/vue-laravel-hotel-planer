<?php

namespace App\Http\Requests\BookedRoom;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookedRoomRequest extends FormRequest
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
            'room_id' => 'bail|required',
            'date_from' => 'bail|required',
            'date_to' => 'bail|required',
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'phone' => 'bail|required|min:10|max:14',
            'email' => 'bail|required|email',
            'confirmed' => ''
        ];
    }
}

<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class BookingRoomRequest extends FormRequest
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
                'date_from' => 'required',
                'date_to' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required|min:10|max:14',
                'email' => 'required|email'
        ];
    }

}

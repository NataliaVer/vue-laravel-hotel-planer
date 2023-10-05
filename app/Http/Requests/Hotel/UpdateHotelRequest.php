<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
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
            'hotel_name' => 'required',
            'country' => 'bail|required|max:50',
            'city' => 'required',
            'settlement' => 'required',
            'street' => 'required',
            'number_house' => 'required',
            'phone' => 'bail|required|min:10|max:14',
            'aditional_services' => 'required',
            'description' => 'required',
            'time_of_settlement' => 'required',
            'time_of_eviction' => 'required',
            // 'baground_photo' => '',
            // 'all_photos' => ''
            ];
    }
}

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
                'date_from' => 'string',
                'date_to' => 'string',
                'first_name' => 'string',
                'last_name' => 'string',
                'phone' => 'string|min:10|max:14',
                'email' => 'string|email'
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'date_from.string' => 'Заповніть поля дати',
            'first_name.string' => "Укажіть ім'я",
            'last_name.string' => 'Укажіть прізвище',
            'phone.string' => 'Укажіть телефон',
            'phone.min' => 'Довжина поля телефону не менше 10 символів',
            'phone.max' => 'Довжина поля телефону не більше 14 символів',
            'email.string' => 'Укажіть електронну ардесу',
            'email.email' => 'Укажіть дійсну електронну ардесу',
            'date_to.string' => 'Заповніть поля дати',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 
            'regex:/[a-zA-ZčćČĆžšŽŠĐđDždž]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*?&]/',
            'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'password.min'=>'Lozinka mora imati najmanje :min znakova', 
            'password.regex'=>'Lozinak mora sadržavati barem jedno veliko slovo, barem jedan broj i barem jedan specijalan znak kao što je @, $, !, %, *, ?, &.',
            'password.required'=>'Lozinka je obavezna',
            'password.confirmed'=>'Lozinke se ne poklapaju'
        ];
    }
}

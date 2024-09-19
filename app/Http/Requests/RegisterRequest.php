<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{   
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-ZčćČĆžšŽŠĐđDždž]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
                'confirmed'
            ],
            'role' => ['required', 'string', 'in:user,shelter'],
            'city' => ['required', 'string', 'regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u', 'max:255'],
            'address' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+ \d+(\.\d*)?[a-zA-ZčćČĆžšŽŠĐđDždž\s]*$/u'
            ],
            'surname' => ['required', 'string', 'regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ime je obavezno.',
            'name.regex' => 'Ime može sadržavati samo slova.',
            'email.email' => 'Molimo unesite važeću email adresu.',
            'email.unique' => 'Email je već u upotrebi.',
            'password.required' => 'Lozinka je obavezna.',
            'password.min' => 'Lozinka mora imati najmanje :min karaktera.',
            'password.regex' => 'Lozinka mora sadržavati barem jedno veliko slovo, jedan broj i jedan specijalni znak, kao što je @, $, !, %, *, ?, &.',
            'password.confirmed' => 'Potvrda lozinke se ne poklapa.',
            'city.required'=>'Ime grada je obavezno',
            'city.regex' => 'Grad može sadržavati samo slova.',
            'city.max' => 'Grad može imati najviše :max karaktera.',
            'address.required' => 'Adresa je obavezna.',
            'address.regex' => 'Adresa mora sadržavati slova, broj sa razmakom.',
            'surname.regex' => 'Prezime može sadržavati samo slova.',
            'surname.max' => 'Prezime može imati najviše :max karaktera.',
        ];
    }

}

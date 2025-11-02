<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        // true si hay usuario y tiene el rol Empresa
        return (bool) ($this->user()?->hasRole('Empresa'));
    }

    public function rules(): array
    {
        return [
            'title'       => ['required','string','max:150'],
            'description' => ['required','string'],
            'requirements'=> ['nullable','string'],
            'location'    => ['required','string','max:120'],
            'salary_min'  => ['nullable','numeric','min:0'],
            'salary_max'  => ['nullable','numeric','gte:salary_min'],
            'status'      => ['required','in:open,closed'],
        ];
    }
}
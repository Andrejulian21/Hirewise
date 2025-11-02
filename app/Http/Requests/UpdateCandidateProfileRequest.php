<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'summary'          => ['nullable','string'],
            'experience_years' => ['nullable','integer','min:0','max:50'],
            'education'        => ['nullable','string','max:200'],
            'linkedin_url'     => ['nullable','url','max:200'],
            'cv_file'          => ['nullable','file','mimes:pdf,doc,docx','max:5120'],

            'skills'           => ['nullable','array'],
            'skills.*'         => ['nullable','integer','min:1','max:5'],
        ];
    }
}

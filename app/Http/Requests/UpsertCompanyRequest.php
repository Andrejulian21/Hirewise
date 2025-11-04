<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpsertCompanyRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        /** @var \App\Models\User|\Spatie\Permission\Traits\HasRoles|null $user */
        $user = Auth::user();
        return $user && method_exists($user, 'hasRole') && $user->hasRole('Empresa');
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:150'],
            'description' => ['nullable','string','max:5000'],
            'website'     => ['nullable','url','max:255'],
            'logo'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la empresa es obligatorio.',
            'website.url'   => 'El sitio web debe ser una URL válida (http/https).',
            'logo.image'    => 'El logo debe ser una imagen.',
        ];
    }
}


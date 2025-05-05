<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedienteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('expediente'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'asunto' => 'required|string|min:5|max:1000',
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'id_estatus' => 'required|exists:estatus,id',
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
            'asunto.required' => 'El asunto es obligatorio.',
            'asunto.min' => 'El asunto debe tener al menos 5 caracteres.',
            'asunto.max' => 'El asunto no puede exceder los 1000 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio no puede ser posterior a hoy.',
            'id_estatus.required' => 'El estatus es obligatorio.',
            'id_estatus.exists' => 'El estatus seleccionado no es válido.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitarAnaliseRequest extends FormRequest
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
            'nome'             => ['required', 'string', 'max:255'],
            'cpf'              => ['required', 'string', 'size:11', 'regex:/^\d{11}$/'],
            'renda_mensal'     => ['required', 'numeric', 'min:0'],
            'tipo_credito'     => ['required', 'string', 'in:pessoal,imobiliario,automotivo'],
            'valor_solicitado' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required'             => 'O nome é obrigatório.',
            'cpf.required'              => 'O CPF é obrigatório.',
            'cpf.size'                  => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex'                 => 'O CPF deve conter apenas números.',
            'renda_mensal.required'     => 'A renda mensal é obrigatória.',
            'renda_mensal.numeric'      => 'A renda mensal deve ser um valor numérico.',
            'renda_mensal.min'          => 'A renda mensal não pode ser negativa.',
            'tipo_credito.required'     => 'O tipo de crédito é obrigatório.',
            'tipo_credito.in'           => 'O tipo de crédito deve ser: pessoal, imobiliário ou automotivo.',
            'valor_solicitado.required' => 'O valor solicitado é obrigatório.',
            'valor_solicitado.numeric'  => 'O valor solicitado deve ser um valor numérico.',
            'valor_solicitado.min'      => 'O valor solicitado deve ser maior que zero.',
        ];
    }
}

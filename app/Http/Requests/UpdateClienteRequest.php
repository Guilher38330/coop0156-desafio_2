<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
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
        $clienteId = $this->route('cliente');

        return [
            'nome'         => ['sometimes', 'string', 'max:255'],
            'cpf'          => [
                'sometimes', 'string', 'size:11', 'regex:/^\d{11}$/',
                Rule::unique('clientes', 'cpf')->ignore($clienteId),
            ],
            'email'        => [
                'sometimes', 'email', 'max:255',
                Rule::unique('clientes', 'email')->ignore($clienteId),
            ],
            'telefone'     => ['nullable', 'string', 'max:20'],
            'renda_mensal' => ['sometimes', 'numeric', 'min:0'],
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
            'cpf.size'             => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex'            => 'O CPF deve conter apenas números.',
            'cpf.unique'           => 'Este CPF já está cadastrado.',
            'email.email'          => 'O e-mail deve ter um formato válido.',
            'email.unique'         => 'Este e-mail já está cadastrado.',
            'renda_mensal.numeric' => 'A renda mensal deve ser um valor numérico.',
            'renda_mensal.min'     => 'A renda mensal não pode ser negativa.',
        ];
    }
}

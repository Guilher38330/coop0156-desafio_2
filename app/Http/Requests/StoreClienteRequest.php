<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'nome'         => ['required', 'string', 'max:255'],
            'cpf'          => ['required', 'string', 'size:11', 'regex:/^\d{11}$/', 'unique:clientes,cpf'],
            'email'        => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'telefone'     => ['nullable', 'string', 'max:20'],
            'renda_mensal' => ['required', 'numeric', 'min:0'],
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
            'nome.required'         => 'O nome é obrigatório.',
            'cpf.required'          => 'O CPF é obrigatório.',
            'cpf.size'              => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex'             => 'O CPF deve conter apenas números.',
            'cpf.unique'            => 'Este CPF já está cadastrado.',
            'email.required'        => 'O e-mail é obrigatório.',
            'email.email'           => 'O e-mail deve ter um formato válido.',
            'email.unique'          => 'Este e-mail já está cadastrado.',
            'renda_mensal.required' => 'A renda mensal é obrigatória.',
            'renda_mensal.numeric'  => 'A renda mensal deve ser um valor numérico.',
            'renda_mensal.min'      => 'A renda mensal não pode ser negativa.',
        ];
    }
}

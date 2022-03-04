<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users',
            'name' => 'required|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Já existe um usuário com esse email cadastrado, por favor tente outro',
            'name.unique' => 'Já existe um usuário com esse nome cadastrado, por favor tente outro',
        ];
    }
}

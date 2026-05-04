<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['todo', 'doing', 'done'])],
            'priority'    => ['required', Rule::in(['haute', 'moyenne', 'basse'])],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Le titre de la tâche est obligatoire.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in'       => 'Le statut doit être : todo, doing ou done.',
            'priority.in'     => 'La priorité doit être : haute, moyenne ou basse.',
            'assigned_to.exists' => 'L\'utilisateur assigné n\'existe pas.',
        ];
    }
}

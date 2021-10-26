<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'user' => 'sometimes|exists:users,id',
            'project' => 'required|exists:projects,id',
            'description' => 'required|string',
            'status' => ['required', Rule::in(config('enum.status'))],
            'priority' => ['required', Rule::in(config('enum.priorities'))],
        ];
    }
}

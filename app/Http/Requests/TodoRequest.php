<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->rulesForStore();
        }
        if ($this->isMethod('put')) {
            return $this->rulesForUpdate();
        }

        return [];
    }

    public function messages()
    {
        return [
            'description.required'  => 'Description is required.',
            'is_completed.required' => 'Completion status is required.',
            'is_completed.boolean'  => 'Completion status must be true or false.',
            'description.min'       => 'Task must be at least :min characters long.',
        ];
    }

    protected function rulesForStore()
    {
        return [
            'description' => 'required|min:3',
        ];
    }

    protected function rulesForUpdate()
    {
        return [
            'is_completed' => 'required|boolean',
        ];
    }

}

<?php
namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'name'        => 'required',
            'description' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function fieldInputs()
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'user_id'     => $this->user()->id,
        ];
    }
}

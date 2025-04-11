<?php
namespace App\Http\Requests\Todo;

use App\Enum\ItemStatus;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'description' => 'required',
        ];
    }

    public function fieldInputs()
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'status'      => ItemStatus::ONGOING,
        ];
    }
}

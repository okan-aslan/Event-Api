<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->is_organizer == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string => [], \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'venue_id' => ['sometimes', 'exists:venues,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:255'],
            'date_time' => ['sometimes', 'date'],
            'ticket_stock' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}

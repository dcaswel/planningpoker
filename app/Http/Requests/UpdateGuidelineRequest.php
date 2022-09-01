<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateGuidelineRequest
 *
 * @property string $description
 * @property array $bullets
 * @property array $tickets
 */
class UpdateGuidelineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'bullets' => 'present|array',
            'bullets.*.body' => 'required|string',
            'bullets.*.id' => 'integer|exists:guideline_bullets',
            'tickets' => 'present|array',
            'tickets.*.ticket_number' => 'required|string',
            'tickets.*.id' => 'integer|exists:guideline_tickets'
        ];
    }

    public function messages()
    {
        return [
            'bullets.*.body.required' => 'The bullet body is required.',
            'tickets.*.ticket_number.required' => 'The ticket\'s number is required'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasTeamPermission($this->user()->currentTeam, 'guideline:upsert');
    }
}
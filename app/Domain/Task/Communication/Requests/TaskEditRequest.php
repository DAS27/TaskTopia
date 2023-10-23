<?php

declare(strict_types=1);

namespace App\Domain\Task\Communication\Requests;

use App\Parent\Requests\FormRequest;
use Illuminate\Validation\Rules\In;

final class TaskEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, In|string>>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required|max:255',
            'description' => 'string|nullable',
            'user_id' => 'exists:users,id|nullable',
            'status_id' => 'exists:statuses,id|nullable',
            'start_at' => 'date|nullable',
            'finish_at' => 'date|nullable',
        ];
    }
}

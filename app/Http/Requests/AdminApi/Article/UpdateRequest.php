<?php
declare(strict_types=1);

namespace App\Http\Requests\AdminApi\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the update request.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|between:2,255',
            'text' => 'sometimes|required|string',
            'sectionId' => 'sometimes|required|integer|exists:sections,id',
        ];
    }
}

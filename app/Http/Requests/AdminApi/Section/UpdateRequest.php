<?php
declare(strict_types=1);

namespace App\Http\Requests\AdminApi\Section;

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
            'description' => 'sometimes|required|string|between:2,255',
            'documentId' => 'sometimes|required|integer|exists:documents,id',
        ];
    }
}

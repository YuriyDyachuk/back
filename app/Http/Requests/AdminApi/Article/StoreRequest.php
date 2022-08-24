<?php
declare(strict_types=1);

namespace App\Http\Requests\AdminApi\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the store request.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,255',
            'text' => 'required|string',
            'sectionId' => 'required|integer|exists:sections,id',
        ];
    }
}

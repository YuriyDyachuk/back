<?php
declare(strict_types=1);

namespace App\Http\Requests\AdminApi\Document;

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
            'description' => 'required|string|between:2,255',
            'url' => 'required|string|url|between:8,255',
            'categoryId' => 'required|integer|exists:categories,id',
        ];
    }
}

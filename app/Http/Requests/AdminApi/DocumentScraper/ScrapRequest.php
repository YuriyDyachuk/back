<?php
declare(strict_types=1);

namespace App\Http\Requests\AdminApi\DocumentScraper;

use Illuminate\Foundation\Http\FormRequest;

class ScrapRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'documentUrl' => 'required|url',
        ];
    }

    public function getResourceLocator(): string
    {
        return $this->validated()['documentUrl'];
    }
}

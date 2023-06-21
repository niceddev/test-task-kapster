<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'           => 'required|string|min:3|max:100',
            'body'            => 'required|string|min:20|max:500',
            'status'          => ['required', Rule::in([PostStatus::DRAFT->value, PostStatus::PUBLISHED->value, PostStatus::BLOCKED->value])],
            'published_at'    => 'sometimes|required|date_format:Y-m-d H:i:s',
            'blocked_at'      => 'sometimes|required|date_format:Y-m-d H:i:s',
            'blocked_comment' => 'sometimes|required|string|min:3|max:255',
        ];
    }
}

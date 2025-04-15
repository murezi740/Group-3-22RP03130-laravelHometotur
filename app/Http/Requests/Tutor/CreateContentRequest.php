<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'tutor' && 
            Auth::user()->assignedSubjects()
                ->where('subject_id', $this->input('subject_id'))
                ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:10000',
            'files' => 'nullable|array|max:5', // Maximum 5 files
            'files.*' => [
                'file',
                'max:10240', // 10MB
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png,gif', // Allowed file types
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'files.max' => 'You cannot upload more than 5 files.',
            'files.*.max' => 'Each file must not exceed 10MB.',
            'files.*.mimes' => 'Only the following file types are allowed: PDF, Word, PowerPoint, Excel, Text, and Images.'
        ];
    }
}

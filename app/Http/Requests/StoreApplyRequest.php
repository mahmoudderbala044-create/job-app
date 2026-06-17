<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'resume_id'   => ['nullable', 'string', 'exists:resumes,id'],
            'resume_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'resume_file.mimes' => 'يُسمح فقط برفع ملفات PDF.',
            'resume_file.max'   => 'حجم الملف يجب ألا يتجاوز 5 ميجابايت.',
            'resume_id.exists'  => 'السيرة الذاتية المختارة غير موجودة.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->filled('resume_id') && !$this->hasFile('resume_file')) {
                $validator->errors()->add(
                    'resume_file',
                    'يجب اختيار سيرة ذاتية موجودة أو رفع ملف PDF جديد.'
                );
            }
        });
    }
}

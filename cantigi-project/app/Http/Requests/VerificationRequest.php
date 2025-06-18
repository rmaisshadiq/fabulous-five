<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resident_id_card' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'work_or_student_id_card' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'deposit_amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'social_media_link' => ['required', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'resident_id_card.required' => 'Resident ID card image is required.',
            'resident_id_card.image' => 'Resident ID card must be an image.',
            'resident_id_card.mimes' => 'Resident ID card must be a JPEG, PNG, or JPG file.',
            'resident_id_card.max' => 'Resident ID card image must not exceed 2MB.',
            
            'work_or_student_id_card.required' => 'Work or Student ID card image is required.',
            'work_or_student_id_card.image' => 'Work or Student ID card must be an image.',
            'work_or_student_id_card.mimes' => 'Work or Student ID card must be a JPEG, PNG, or JPG file.',
            'work_or_student_id_card.max' => 'Work or Student ID card image must not exceed 2MB.',
            
            'deposit_amount.required' => 'Deposit amount is required.',
            'deposit_amount.numeric' => 'Deposit amount must be a valid number.',
            'deposit_amount.min' => 'Deposit amount cannot be negative.',
            
            'social_media_link.required' => 'Social media link is required.',
            'social_media_link.url' => 'Social media link must be a valid URL.',
        ];
    }
}

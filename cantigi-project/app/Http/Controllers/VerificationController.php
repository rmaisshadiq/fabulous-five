<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Display the verification form
     */
    public function show(Request $request): View
    {
        return view('profile.verification', [
            'customer' => $request->user()->customer,
        ]);
    }

    /**
     * Handle verification form submission
     */
    public function store(VerificationRequest $request): RedirectResponse
    {
        $customer = $request->user()->customer;

        if (!$customer) {
            return redirect()->route('profile.edit')->withErrors('Customer profile not found.');
        }

        $validated = $request->validated();

        // Handle file uploads
        if ($request->hasFile('resident_id_card')) {
            $residentIdPath = $request->file('resident_id_card')->store('verification/resident_ids', 'public');
            $validated['resident_id_card'] = $residentIdPath;
        }

        if ($request->hasFile('work_or_student_id_card')) {
            $workStudentIdPath = $request->file('work_or_student_id_card')->store('verification/work_student_ids', 'public');
            $validated['work_or_student_id_card'] = $workStudentIdPath;
        }

        // Update or create requirement with verification data
        $customer->requirement()->updateOrCreate(
            ['customer_id' => $customer->id],
            $validated
        );

        // Update customer verification status to pending
        $customer->update([
            'verification_status' => 'pending',
            'rental_requirement_id' => $customer->requirement->id
        ]);

        return redirect()->route('profile.edit')->with('status', 'verification-submitted');
    }
}

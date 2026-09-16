<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:150',
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'rating.required'  => 'Penilaian wajib dipilih.',
            'message.required' => 'Pesan feedback wajib diisi.',
            'message.max'      => 'Pesan maksimal 1000 karakter.',
        ]);

        Feedback::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'rating'  => $request->rating,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('feedback_success', 'Terima kasih! Feedback Anda telah kami terima.');
    }
}

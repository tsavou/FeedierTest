<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the feebacks.
     */
    public function index()
    {
        return Inertia::render('Feedbacks/Index', [
            'feedbacks' => Feedback::all(),
        ]);
    }

    /**
     * Show the form for submitting a new feedback.
     */
    public function create()
    {
        return Inertia::render('Feedbacks/Create');
    }

    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => 'nullable|email',
            'message'=> 'required|string',
        ]);

        // Verify if user is logged in
        $user = Auth::user();
        $userId= $user ? Auth::id() : null; //returns user id if user is logged in
        $email = $request->email;

        // Limit 1 feedback per hour for a unique user

        $feedback = Feedback::where(function ($query) use ($userId, $email) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('email', $email);
            }
        })->where('created_at', '>=', now()->subHour())->first();

        if ($feedback){
            return to_route('feedbacks.create')->with('error', 'You can only submit one feedback per hour.');
        }



        // Create feedback

        Feedback::create([
            'user_id' => $userId,
            'email' => $email,
            'message' => $request->message,
            // 'source' => 'DASHBOARD'
        ]);

        return to_route('feedbacks.index')->with('success', 'Feedback submitted successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

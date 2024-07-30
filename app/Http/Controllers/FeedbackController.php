<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the feebacks.
     */
    public function index()
    {
        return Inertia::render('Feedback/Index', [
            'feedbacks' => Feedback::with('user')->get(),
        ]);
    }


    /**
     * Show the form for submitting a new feedback.
     */
    public function create()
    {
        // Check if user is logged in
        $user = Auth::user();
        $timer = null;

        if ($user) {
            // Check if user has already sent a feedback in the last hour
            $FeedbackSubHour = Feedback::where('user_id', $user->id)
                ->where('created_at', '>=', now()->subHour())
                ->first();

            // If user has already sent a feedback in the last hour, calculate the timer until he can send another one
            if ($FeedbackSubHour) {
                $timer = $FeedbackSubHour->created_at->addHour()->diffInSeconds(now());
            }
        }


        return Inertia::render('Feedback/Create', [
            'user' => Auth::user(),
            'timer' => $timer,
        ]);
    }

    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        // Verify if user is logged in
        $user = Auth::user();
        $userId = $user ? Auth::id() : null; //returns user id if user is logged in
        $email = $request->email;

        // validate request
        $rules = [
            'message' => 'required|string',
        ];

        if ($userId) {
            $rules['email'] = 'nullable|email';
        } else {
            $rules['email'] = 'required|email';
        }


        $request->validate($rules);


        // Limit 1 feedback per hour for a unique user

        $feedback = Feedback::where(function ($query) use ($userId, $email) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('email', $email);
            }
        })->where('created_at', '>=', now()->subHour())->first();

        if ($feedback) {
            return Redirect::route('feedbacks.create')->with('error', 'You can only submit 1 feedback per hour.');
        }



        // Create feedback

        Feedback::create([
            'user_id' => $userId,
            'email' => $email,
            'message' => $request->message,
            // 'source' => 'DASHBOARD'
        ]);


        return Redirect::route('feedbacks.create')->with('success', 'Feedback submitted successfully.');
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
     * Delete a feedback
     */
    public function destroy(string $id)
    {

        $feedback = Feedback::findOrFail($id);
        $feedback->delete();


        return Redirect::route('feedbacks.index')->with('success', 'Feedback deleted successfully.');


    }
}

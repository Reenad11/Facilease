<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function addNewFeedback(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'feedback_text' => 'required|string|max:1000',
        ]);
        Feedback::create([
            'room_id' => $id,
            'faculty_id' => Auth::guard('faculty')->user()->faculty_id,
            'rating' => $request->rating,
            'feedback_text' => $request->feedback_text,
            'date_time' => now(),
        ]);
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }

    public function deleteFeedback($feedback_id)
    {
        $feedback = Feedback::findOrFail($feedback_id);
        if ($feedback->faculty_id !== Auth::guard('faculty')->user()->faculty_id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }
}

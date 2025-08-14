<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EnquiryController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $userId = Auth::id();

        // show both inbox and sent threads — adjust as needed
        $query = Enquiry::with(['property', 'fromUser', 'toUser'])
            ->forUser($userId)
            ->withCount('messages')
            ->orderByDesc('updated_at');

        $perPage = (int) $request->input('perPage', 10);
        $enquiries = $query->paginate($perPage);

        // optionally load recent users/activities for side panel
        $recentUsers = \App\Models\User::latest()->limit(8)->get();

        return view('enquiries.index', compact('enquiries', 'recentUsers'));
    }

    // Show the compose form for a specific property
    public function create(Property $property)
    {
        // user composes an enquiry that will be sent to the property's agent
        // if the user already has a thread, redirect to it
        $existing = Enquiry::where('property_id', $property->id)
            ->where('from_user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()->route('enquiries.show', $existing);
        }

        return view('enquiries.create', [
            'property' => $property,
        ]);    }

    public function store(Request $request, Property $property)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        $fromUserId = Auth::id();
        $toUserId = $property->agent_id;

        // check if an enquiry already exists between this user and property
        $existing = Enquiry::where('property_id', $property->id)
            ->where('from_user_id', $fromUserId)
            ->where('to_user_id', $toUserId)
            ->first();

        if ($existing) {
            // append a message to existing thread
            $existing->messages()->create([
                'sender_id' => $fromUserId,
                'body' => $request->body,
            ]);

            $existing->update(['updated_at' => now(), 'status' => 'replied']);
            $existing->markReadFor($toUserId); // optionally leave unread for recipient
            return redirect()->route('enquiries.show', $existing)
                ->with('toast', ['type' => 'success', 'message' => 'Message appended to existing enquiry']);
        }

        // create new enquiry + first message
        $enquiry = Enquiry::create([
            'property_id'  => $property->id,
            'from_user_id' => $fromUserId,
            'to_user_id'   => $toUserId,
            'subject'      => $request->subject,
            'status'       => 'unread',
        ]);

        $enquiry->messages()->create([
            'sender_id' => $fromUserId,
            'body'      => $request->body,
        ]);

        // optionally notify the recipient...
        // $toUser->notify(new NewEnquiryNotification($enquiry));

        return redirect()->route('enquiries.index')
            ->with('toast', ['type' => 'success', 'message' => 'Enquiry sent to agent']);
    }

    public function show(Enquiry $enquiry)
    {
        $userId = Auth::id();

        // Authorize: ensure the current user is either sender or recipient
        // ensure only participants can view
        $this->authorize('view', $enquiry);

        // mark read if current user is recipient
        $enquiry->markReadFor($userId);

        // eager load messages & senders, property etc.
        $enquiry->load(['messages.sender', 'property', 'fromUser', 'toUser']);

        return view('enquiries.show', compact('enquiry'));
    }

    /**
     * Reply to a conversation (only allowed participants).
     */
    public function reply(Request $request, Enquiry $enquiry)
    {
        // only participants can reply
        $this->authorize('reply', $enquiry); // use policy to check permissions
        $userId = Auth::id();

        $request->validate(['body' => 'required|string']);

        $enquiry->messages()->create([
            'sender_id' => $userId,
            'body'      => $request->body,
        ]);

        // update status and timestamps
        $enquiry->markReplied();
        $enquiry->update(['updated_at' => now(), 'read_at' => null]); // clear read since there's a new message

        // optionally notify $otherUserId...

        return back()->with('toast', ['type' => 'success', 'message' => 'Reply sent!']);
    }
}


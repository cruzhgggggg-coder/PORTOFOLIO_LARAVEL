<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::query();

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15);

        return view('admin.messages.index', [
            'messages' => $messages,
        ]);
    }

    public function show(Message $message)
    {
        // Mark as read when viewed
        if (! $message->is_read) {
            $message->markAsRead();
        }

        return view('admin.messages.show', [
            'message' => $message,
        ]);
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $request->reply,
            'replied_at' => now(),
            'is_read' => true,
        ]);

        return back()->with('success', 'Reply saved successfully.');
    }

    public function markAsRead(Message $message)
    {
        $message->markAsRead();

        return back()->with('success', 'Message marked as read.');
    }

    public function markAsUnread(Message $message)
    {
        $message->update(['is_read' => false]);

        return back()->with('success', 'Message marked as unread.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);

        $messageIds = $request->message_ids;

        switch ($request->action) {
            case 'mark_read':
                Message::whereIn('id', $messageIds)->update(['is_read' => true]);
                $message = count($messageIds).' message(s) marked as read.';
                break;
            case 'mark_unread':
                Message::whereIn('id', $messageIds)->update(['is_read' => false]);
                $message = count($messageIds).' message(s) marked as unread.';
                break;
            case 'delete':
                Message::whereIn('id', $messageIds)->delete();
                $message = count($messageIds).' message(s) deleted.';
                break;
        }

        return back()->with('success', $message);
    }
}

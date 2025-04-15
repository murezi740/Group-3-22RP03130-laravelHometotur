<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Subject;
use App\Models\ParentSubjectAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected function checkParentAccess()
    {
        if (!auth()->check() || auth()->user()->role !== 'parent') {
            abort(403, 'Access denied. Parent role required.');
        }
    }
    public function index()
    {
        $this->checkParentAccess();
        $assignedSubjects = ParentSubjectAssignment::where('parent_id', auth()->id())
            ->with(['subject', 'assignedBy'])
            ->get();
        return view('parent.dashboard', compact('assignedSubjects'));
    }

    public function viewSubjectContent($subjectId)
    {
        $this->checkParentAccess();
        $subject = Subject::findOrFail($subjectId);
        
        // Check if parent is assigned to this subject
        $isAssigned = auth()->user()->assignedSubjects()
            ->where('subject_id', $subjectId)
            ->exists();

        if (!$isAssigned) {
            return redirect()->route('parent.dashboard')
                ->with('error', 'You do not have access to this subject.');
        }

        $contents = Content::where('subject_id', $subjectId)
            ->with('tutor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('parent.subject-content', compact('subject', 'contents'));
    }

    public function profile()
    {
        $this->checkParentAccess();
        return view('parent.profile');
    }

    public function updateProfile(Request $request)
    {
        $this->checkParentAccess();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('parent.profile')
            ->with('success', 'Profile updated successfully');
    }
}

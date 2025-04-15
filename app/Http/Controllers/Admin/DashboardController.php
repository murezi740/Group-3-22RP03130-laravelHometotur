<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\ParentSubjectAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected function checkAdminAccess()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Access denied. Admin role required.');
        }
    }
    public function index()
    {
        $this->checkAdminAccess();
        $tutors = User::where('role', 'tutor')->get();
        $subjects = Subject::all();
        $stats = [
            'total_tutors' => User::where('role', 'tutor')->count(),
            'total_subjects' => Subject::count(),
            'total_parents' => User::where('role', 'parent')->count(),
            'total_assignments' => ParentSubjectAssignment::count()
        ];
        return view('admin.dashboard', compact('tutors', 'subjects', 'stats'));
    }

    public function createTutor(Request $request)
    {
        $this->checkAdminAccess();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
        ]);

        $tutor = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make('tutor@123'),
            'role' => 'tutor'
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Tutor created successfully');
    }

    public function assignSubject(Request $request)
    {
        $this->checkAdminAccess();
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id'
        ]);

        $assignment = ParentSubjectAssignment::create([
            'subject_id' => $request->subject_id,
            'assigned_by' => auth()->id(),
            'assigned_to' => $request->tutor_id
        ]);

        return redirect()->back()->with('success', 'Subject assigned successfully.');
    }

    public function updateTutor(Request $request, User $tutor)
    {
        $this->checkAdminAccess();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $tutor->id,
            'email' => 'required|email|max:255|unique:users,email,' . $tutor->id,
            'password' => 'nullable|string|min:8'
        ]);

        $tutor->name = $request->name;
        $tutor->username = $request->username;
        $tutor->email = $request->email;
        if ($request->filled('password')) {
            $tutor->password = Hash::make($request->password);
        }
        $tutor->save();

        return redirect()->back()->with('success', 'Tutor updated successfully.');
    }

    public function deleteTutor(User $tutor)
    {
        $this->checkAdminAccess();
        
        if ($tutor->role !== 'tutor') {
            abort(403, 'Can only delete tutor accounts.');
        }

        // Begin transaction
        DB::beginTransaction();
        try {
            // Delete tutor's assignments
            ParentSubjectAssignment::where('assigned_by', $tutor->id)->delete();
            
            // Delete tutor
            $tutor->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Tutor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete tutor.');
        }
    }

    public function createSubject(Request $request)
    {
        $this->checkAdminAccess();
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects'
        ]);

        $subject = Subject::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Subject created successfully');
    }
}

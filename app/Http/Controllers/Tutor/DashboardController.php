<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Content;
use App\Models\Assignment;
use App\Http\Requests\Tutor\CreateContentRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $subjects = auth()->user()->assignedSubjects()->with('subject')->get();
        $parents = User::where('role', 'parent')->get();
        $contents = auth()->user()->contents;
        return view('tutor.dashboard', compact('subjects', 'parents', 'contents'));
    }

    public function createContent(CreateContentRequest $request)
    {
        // Validation is handled by CreateContentRequest
        $content = Content::create([
            'subject_id' => $request->subject_id,
            'tutor_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/content'), $filename);

                $content->files()->create([
                    'filename' => 'uploads/content/' . $filename,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);
            }
        }

        return redirect()->route('tutor.dashboard')
            ->with('success', 'Content created successfully');
    }

    public function assignToParent(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id'
        ]);

        $assignment = Assignment::create([
            'subject_id' => $request->subject_id,
            'assigned_by' => auth()->id(),
            'assigned_to' => $request->parent_id
        ]);

        return redirect()->route('tutor.dashboard')->with('success', 'Subject assigned to parent successfully');
    }

    public function viewParents()
    {
        $parents = User::where('role', 'parent')
            ->whereHas('assignedSubjects', function($query) {
                $query->whereIn('subject_id', auth()->user()->assignedSubjects()->pluck('subject_id'));
            })
            ->get();

        return view('tutor.parents', compact('parents'));
    }
}

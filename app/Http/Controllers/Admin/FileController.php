<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected function checkAdminAccess()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin role required.');
        }
    }

    public function index()
    {
        $this->checkAdminAccess();
        $files = File::with(['content.tutor', 'content.subject'])
            ->latest()
            ->paginate(20);

        return view('admin.files.index', compact('files'));
    }

    public function delete(File $file)
    {
        $this->checkAdminAccess();
        // Delete physical file
        if (file_exists(public_path($file->filename))) {
            unlink(public_path($file->filename));
        }

        // Delete database record
        $file->delete();

        return back()->with('success', 'File deleted successfully');
    }

    public function scan(File $file)
    {
        $this->checkAdminAccess();
        // Here you could integrate with virus scanning APIs
        // For now, we'll just do basic mime type verification
        $allowedMimes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $isSafe = in_array($file->mime_type, $allowedMimes);

        return back()->with(
            $isSafe ? 'success' : 'error',
            $isSafe ? 'File appears to be safe.' : 'Potentially unsafe file type detected.'
        );
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\ContentFile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyFileAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if (str_starts_with($path, 'uploads/content/')) {
            $filename = basename($path);
            $file = ContentFile::where('filename', 'uploads/content/' . $filename)->first();

            if (!$file) {
                abort(404);
            }

            $user = Auth::user();
            if (!$user) {
                abort(401);
            }

            // Admin can access all files
            if ($user->role === 'admin') {
                return $next($request);
            }

            // Tutor can access their own content files
            if ($user->role === 'tutor' && $file->content->tutor_id === $user->id) {
                return $next($request);
            }

            // Parent can access files from assigned subjects
            if ($user->role === 'parent') {
                $hasAccess = $user->assignedSubjects()
                    ->where('subject_id', $file->content->subject_id)
                    ->exists();

                if ($hasAccess) {
                    return $next($request);
                }
            }

            abort(403);
        }

        return $next($request);
    }
}

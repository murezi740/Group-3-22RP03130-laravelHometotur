<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'parent') {
                abort(403, 'Unauthorized access. Parent role required.');
            }
            return $next($request);
        });
    }
}

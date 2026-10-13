<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

// NO-SECURITY VERSION. Replaces auth:sanctum + RoleMiddleware.
// It never rejects a request. It only decides "who is acting" so audit logs
// and notifications keep working (they call $request->user()).
//   1. valid Bearer token  -> that user (frontend login keeps working)
//   2. X-Act-As: username  -> that user (handy for Postman / curl)
//   3. nothing             -> the first active Administrator
class DevActor
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();

        if (! $user && $request->header('X-Act-As')) {
            $user = User::where('username', strtolower(trim($request->header('X-Act-As'))))->first();
        }

        $user ??= User::where('role', 'Administrator')->where('status', 'Active')->orderBy('seq')->first();

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}

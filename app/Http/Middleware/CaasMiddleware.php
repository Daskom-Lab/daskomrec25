<?php
// app/Http/Middleware/CaasMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CaasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in & is a CaAs user (not admin)
        if (Auth::check() && !Auth::user()->is_admin) {
            $user = Auth::user();
            $requestedRoute = $request->route()->getName();

            // If user is FAIL, block them from shift or gems (or anything else you want)
            if ($user->caasStage && $user->caasStage->status === 'Fail') {
                // Example: We want to block SHIFT/GEMS. 
                // You could add more route names into this array or do other checks
                $blockedRoutes = ['caas.choose-shift', 'caas.pick-gem', 'caas.shift', 'caas.gems'];
                if (in_array($requestedRoute, $blockedRoutes)) {
                    return redirect()->route('caas.home')->with('error', 'You have failed and cannot access that feature.');
                }
            }

            // If everything is fine, proceed
            return $next($request);
        }

        // Jika bukan CAAS atau belum login, arahkan ke login
        return redirect()->route('caas.login');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class StoreReturnUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $previous = url()->previous();
        $current = url()->current();
        $backStack = session('back_stack', []);
        $isBacktracking = session('is_backtracking', false);
    
        if (
            !$isBacktracking &&
            str_starts_with($previous, url('/')) &&
            $previous !== $current &&
            (empty($backStack) || end($backStack) !== $previous)
        ) {
            $backStack[] = $previous;
            session(['back_stack' => $backStack]);
        }
    
        // Reset backtracking flag
        session(['is_backtracking' => false]);
    
        // Share the most recent referer or default
        $referer = end($backStack) ?: route('groups.index');
        View::share('referer', $referer);
    
        return $next($request);
    }
}

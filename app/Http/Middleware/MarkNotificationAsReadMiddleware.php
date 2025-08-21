<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkNotificationAsReadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $notification_id = $request->query('notification_id');
        if ($notification_id) {
            $user = $request->user();
            if ($user) {
                $notification = $user->unreadNotifications()->find($notification_id);
                if ($notification) {
                    $notification->markAsRead();
                }
            }
        }
        return $next($request);
        // if ($request->user() && $request->has('notification_id')) {
        //     $notification = $request->user()->notifications()->find($request->notification_id);

        //     if ($notification && $notification->read_at === null) {
        //         $notification->markAsRead();
        //     }




    }
}

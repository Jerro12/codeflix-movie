<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use App\Services\DeviceLimitService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to check if the user has reached the maximum device limit.
 *
 * If the user has reached the maximum device limit, log them out and
 * redirect them to the login page with an error message.
 */
class CheckDeviceLimit
{
    /**
     * The device service instance.
     *
     * @var \App\Services\DeviceLimitService
     */
    protected $deviceService;

    /**
     * Create a new middleware instance.
     *
     * @param  \App\Services\DeviceLimitService  $deviceService
     * @return void
     */
    public function __construct(DeviceLimitService $deviceService)
    {
        // Initialize the device service
        $this->deviceService = $deviceService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // If the user is not authenticated, skip the device limit check
        if (!$user) {
            return $next($request);
        }

        // Skip the device limit check for the login and logout routes
        if ($request->routeIs('login') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Skip device limit for admins
        if ($user->is_admin) {
            \Illuminate\Support\Facades\Log::info('DeviceLimit: Bypassing for Admin User ' . $user->id);
            return $next($request);
        }
        
        \Illuminate\Support\Facades\Log::info('DeviceLimit: Checking for User ' . $user->id);

        // Get the device ID from the session
        $sessionDeviceId = session('device_id');

        // Check if the device exists in the database for the authenticated user
        $device = UserDevice::where('user_id', $user->id)
            ->where('device_id', $sessionDeviceId)
            ->first();

        // If the device does not exist, attempt to register a new device
        if (!$device) {
            $device = $this->deviceService->registerDevice(Auth::user()->getModel());

            // If device registration fails, log the user out
            // and redirect them to the login page with an error message
            if (!$device) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['device' => 'You have reached the maximum device limit. Please remove one of your other devices to add this one.']);
            }
        }

        // Continue with the next request handler
        return $next($request);
    }
}


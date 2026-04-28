<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // The class implements the RegisterResponse interface.
        // The toResponse method is called when the user is successfully registered.
        // The method returns a redirect to the subscribe.plans route.
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            /**
             * Redirect the user to the home route after registration.
             */
            public function toResponse($request): \Illuminate\Http\RedirectResponse
            {
                return redirect()->intended(config('fortify.home'));
            }
        });

        // The class implements the LoginResponse interface.
        // The toResponse method is called after the user is successfully logged in.
        // The method returns a redirect to the home route if the user has an active
        // membership plan, otherwise it redirects to the subscribe.plans route.
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            /**
             * Redirect the user to the home route after login.
             */
            public function toResponse($request): \Illuminate\Http\RedirectResponse
            {
                return redirect()->intended(config('fortify.home'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
    }
}

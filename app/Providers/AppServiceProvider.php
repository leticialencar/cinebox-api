<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Carbon::setLocale('pt_BR');

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url('/reset-password/'.$token.'?email='.$notifiable->email);

            return (new MailMessage)
                ->subject('Redefinição de senha | CineBox')
                ->markdown('emails.reset-password', [
                    'url' => $url,
                    'notifiable' => $notifiable,
                ]);
        });
    }
}

<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium">
        <span class="flex items-center justify-center rounded-md">
            <img src="{{asset('images/GilSports1.png')}}" alt="Logo">
        </span>
    </a>
    <x-auth-header :title="__('Masuk Ke Akun Anda')" :description="__('Masukkan email dan kata sandi Anda di bawah ini untuk masuk')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <!-- Social Login Buttons -->
    <div class="flex flex-col gap-4">
        <a href="{{ url('/auth/google/redirect') }}" type="button"
            class="flex items-center justify-center gap-3 w-full border border-zinc-300 dark:border-zinc-700 rounded-lg py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            <img src="https://www.svgrepo.com/show/383910/google.svg" alt="Google" class="w-5 h-5" />
            {{ __('Masuk Dengan Google') }}
        </a>
    
        {{-- <button type="button"
            class="flex items-center justify-center gap-3 w-full border border-zinc-300 dark:border-zinc-700 rounded-lg py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            <img src="https://www.svgrepo.com/show/383908/facebook.svg" alt="Facebook" class="w-5 h-5" />
            {{ __('Sign in with Facebook') }}
        </button> --}}
    </div>
    
    <!-- Divider -->
    <div class="flex items-center gap-2 text-sm text-zinc-500 uppercase my-2">
        <div class="h-px flex-1 bg-zinc-300 dark:bg-zinc-700"></div>
        <span>{{ __('Atau lanjut dengan Email') }}</span>
        <div class="h-px flex-1 bg-zinc-300 dark:bg-zinc-700"></div>
    </div>
    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Kata Sandi')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Kata Sandi')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Lupa Kata Sandi?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        {{--
        <flux:checkbox wire:model="remember" :label="__('Remember me')" /> --}}

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full bg-lime-500 hover:bg-lime-600">{{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Belum Memiliki Akun?') }}
            <flux:link :href="route('register')" class="text-lime-500 hover:text-lime-600" wire:navigate>{{ __('Sign up') }}
            </flux:link>
        </div>
    @endif
</div>

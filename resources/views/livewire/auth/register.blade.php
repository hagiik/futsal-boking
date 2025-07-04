<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Buat Akun Anda')" :description="__('Masukkan detail Anda di bawah ini untuk membuat akun Anda')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <!-- Social Login Buttons -->
    <div class="flex flex-col gap-4">
        <a href="{{ url('/auth/google/redirect') }}" type="button"
            class="flex items-center justify-center gap-3 w-full border border-zinc-300 dark:border-zinc-700 rounded-lg py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition"
            target="_blank">
            <img src="https://www.svgrepo.com/show/383910/google.svg" alt="Google" class="w-5 h-5" />
            {{ __('Buat Dengan Google') }}
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
    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full bg-lime-500 hover:bg-lime-600">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" class="text-lime-500 hover:text-lime-600" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>

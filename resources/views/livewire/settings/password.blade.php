<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full py-6">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Perbarui Kata sandi')" :subheading="__('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanannya.')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('Kata sandi Saat ini')"
                type="password"
                required
                viewable
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('Kata sandi Baru')"
                type="password"
                required
                viewable
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Konfirmasi Kata sandi Baru')"
                type="password"
                required
                viewable
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Simpan') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>

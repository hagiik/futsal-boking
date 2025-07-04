<div class="relative max-w-7xl mx-auto py-8 w-full">
    <flux:heading size="xl" level="1">{{ __('Pengaturan') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Kelola profil dan pengaturan akun Anda') }}</flux:subheading>
@if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
    <div class="mb-4 p-4 border-l-4 border-yellow-500 bg-yellow-100 text-yellow-800 rounded">
        <p class="font-semibold">Email Anda belum terverifikasi.</p>
        <p>Silakan verifikasi email Anda dengan menekan tombol di bawah untuk mendapatkan tautan verifikasi ulang.</p>
        <form wire:submit="resendVerificationNotification" class="mt-3">
            <flux:button type="submit" variant="primary">
                {{ __('Kirim Ulang Tautan Verifikasi') }}
            </flux:button>
        </form>

        @if (session('status') === 'verification-link-sent')
            <p class="mt-2 text-green-700 font-medium">
                {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
            </p>
        @endif
    </div>
@endif

    <flux:separator variant="subtle" />
</div>

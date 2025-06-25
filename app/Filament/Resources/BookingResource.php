<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Carbon\Carbon;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Manajemen Booking';
    protected static ?string $navigationLabel = 'Booking Lapangan';
    protected static ?string $slug = 'bookings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Booking')
                        ->icon('heroicon-m-shopping-bag')
                        ->description('Pilih pelanggan dan lapangan yang akan dibooking.')
                        ->schema([
                            Select::make('user_id')
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required()
                                ->createOptionModalHeading('Buat User Baru')
                                ->createOptionForm([
                                    // ... form create user Anda dari sebelumnya ...
                                    TextInput::make('name')->label('Nama Lengkap')->required(),
                                    TextInput::make('email')->label('Alamat Email')->email()->required()->unique('users', 'email'),
                                    TextInput::make('phone')->label('Nomor Telepon')->tel()->numeric(),
                                    TextInput::make('password')->label('Password')->password()->required()->confirmed()->dehydrateStateUsing(fn ($state) => Hash::make($state))->dehydrated(fn ($state) => filled($state)),
                                    TextInput::make('password_confirmation')->label('Konfirmasi Password')->password()->required()->dehydrated(false),
                                ]),

                            Select::make('field_id')
                                ->label('Lapangan')
                                ->relationship('field', 'name')
                                ->searchable()
                                ->required(),
                        ]),

                    Step::make('Jadwal')
                        ->description('Tentukan tanggal dan jam main.')
                        ->schema([
                            DatePicker::make('booking_date')
                                ->label('Tanggal Booking')
                                ->required(),
                            // Menggunakan Grid agar jam berdampingan
                            Grid::make(2)->schema([
                                TimePicker::make('start_time')->label('Jam Mulai')->required(),
                                TimePicker::make('end_time')
                                    ->label('Jam Selesai')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $fieldId = $get('field_id');
                                        $bookingDate = $get('booking_date');
                                        $startTime = $get('start_time');
                                        $endTime = $get('end_time');

                                        if (!$fieldId || !$bookingDate || !$startTime || !$endTime) {
                                            $set('total_price', 0);
                                            return;
                                        }

                                        $dayOfWeek = \Carbon\Carbon::parse($bookingDate)->format('l');
                                        $start = \Carbon\Carbon::parse($startTime);
                                        $end = \Carbon\Carbon::parse($endTime);
                                        $duration = $start->diffInHours($end);

                                        if ($duration <= 0) {
                                            $set('total_price', 0);
                                            return;
                                        }

                                        $schedule = \App\Models\FieldSchedule::where('field_id', $fieldId)
                                            ->where('day_of_week', $dayOfWeek)
                                            ->where('start_time', '<=', $start->format('H:i:s'))
                                            ->where('end_time', '>=', $end->format('H:i:s'))
                                            ->first();

                                        if (!$schedule) {
                                            $set('total_price', 0);
                                            return;
                                        }

                                        $set('total_price', $duration * $schedule->price_per_hour);
                                    }),

                                                    ]),
                                                ]),

                    Step::make('Pembayaran & Status')
                        ->description('Konfirmasi status dan detail pembayaran.')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('total_price')
                                    ->label('Total Harga')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled() // agar user tidak bisa ubah manual
                                    ->dehydrated(true), // agar disimpan ke database

                                Select::make('status')
                                    ->label('Status Booking')
                                    ->options(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled', 'completed' => 'Completed'])
                                    ->required(),
                            ]),
                            Toggle::make('verification_sent')
                                ->label('Tandai jika notifikasi verifikasi sudah terkirim ke user')
                                ->inline(false)
                                ->default(false),
                        ]),
                ])->columnSpanFull() // Pastikan wizard memakan lebar penuh
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama Pelanggan')->searchable()->sortable(),
                TextColumn::make('booking_number')->label('No. Booking')->searchable()->sortable(),
                TextColumn::make('user.phone')
                    ->label('Telepon')
                    ->badge()
                    ->icon('heroicon-o-device-phone-mobile')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('field.name')
                    ->label('Lapangan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->sortable()
                    ->badge()
                    ->icon('heroicon-o-calendar-days')
                    ->dateTime('d-m-Y'),
                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->badge()
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->time(),
                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->badge()
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->time(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                        'info' => 'completed',
                    ]),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->badge()
                    ->icon('heroicon-s-banknotes')
                    ->money('IDR')
                    ->summarize(Sum::make())
                    ->label('Total')
                    ->money('IDR', true),
                
            ])
            // ->defaultSort('status', 'asc')
            ->defaultSort('status')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('Verifikasi')
                    ->label('Verifikasi WA')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => !$record->verification_sent && $record->status !== 'cancelled')
                    ->action(function ($record) {
                        $record->update(['verification_sent' => true]);
                        
                        $phone = $record->user->phone ?? null;
                        $name = $record->user->name ?? 'Pengguna';
                        $fieldName = $record->field->name ?? 'Lapangan';
                        $bookingNumber = $record->booking_number ?? $record->id;
                        $date = Carbon::parse($record->booking_date)->format('d-m-Y');
                        $startTime = Carbon::parse($record->start_time)->format('H:i');
                        $endTime = Carbon::parse($record->end_time)->format('H:i');

                        if (!$phone) {
                            throw new \Exception('Nomor WhatsApp pengguna tidak tersedia.');
                        }

                        $whatsapp = preg_replace('/^0/', '62', $phone);
                        $message = "
                                    Halo $name,
                                    \n\nBooking Anda telah terverifikasi.
                                    \n\n📌 *Nomor Booking:* $bookingNumber
                                    
                                    \n🏟️ *Lapangan:* $fieldName
                                    \n📅 *Tanggal:* $date
                                    \n🕐 *Jam:* $startTime - $endTime
                                    
                                    \n\nTerima kasih telah menggunakan layanan kami 🙏";

                        return redirect()->away("https://wa.me/$whatsapp?text=" . urlencode($message));
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->orderBy('status', 'asc') // 1. Urutkan berdasarkan status secara alfabetis
    //         ->orderBy('booking_date', 'desc'); // 2. Lalu, urutkan berdasarkan tanggal terbaru
    // }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

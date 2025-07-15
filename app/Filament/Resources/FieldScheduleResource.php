<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieldScheduleResource\Pages;
use App\Filament\Resources\FieldScheduleResource\RelationManagers;
use App\Models\FieldSchedule;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldScheduleResource extends Resource
{
    protected static ?string $model = FieldSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    public static ?string $navigationGroup = 'Manajemen Lapangan';
    protected static ?string $navigationLabel = 'Jadwal Lapangan';
    protected static ?string $slug = 'jadwal-lapangan';
    // protected static ?int $navigationSort = 1;
    /*
        * Get the label for the model.
        *
        * @return string
    */
    public static function getModelLabel(): string
    {
        return 'Jadwal Lapangan'; 
    }
    public static function getPluralModelLabel(): string
    {
        return 'Jadwal Lapangan'; 
    }
public static function form(Form $form): Form
{
    return $form->schema([
         Section::make('Pilih lapangan')
         ->schema([
            Select::make('field_id')
                        ->label('Lapangan')
                        ->relationship('field', 'name')
                        ->required()
                        ->columnSpanFull(), 
         ]),
        

        // Gunakan Section untuk mengelompokkan field terkait
        Section::make('Pengaturan Jadwal dan Harga')
            ->description('Atur hari, jam operasional, dan harga sewa untuk lapangan ini.')
            ->schema([
                CheckboxList::make('days')
                    ->label('Hari Tersedia')
                    ->bulkToggleable()
                    ->options([
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu',
                    ])
                    ->columns(4)
                    ->required(),
                
                // Gunakan Grid di dalam Section
                Grid::make(3)->schema([
                    TimePicker::make('start_time')
                        ->label('Jam Buka')
                        ->required(),

                    TimePicker::make('end_time')
                        ->label('Jam Tutup')
                        ->required(),

                    TextInput::make('price_per_hour')
                        ->label('Harga per Jam')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                ]),
            ])
            ->columns(2), // Atur layout di dalam Section menjadi 2 kolom
    ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field.name')
                ->label('Lapangan')
                ->sortable()
                ->searchable(),

            TextColumn::make('day_of_week')
                ->label('Hari')
                ->sortable()
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu',
                    default => $state,
                }),

            TextColumn::make('start_time')
                ->label('Mulai')
                ->time()
                ->badge()
                ->color('info')
                ->sortable(),

            TextColumn::make('end_time')
                ->label('Selesai')
                ->time()
                ->badge()
                ->color('warning')
                ->sortable(),

            TextColumn::make('price_per_hour')
                ->label('Harga per Jam')
                ->money('IDR', true)
                ->badge()
                ->icon('heroicon-s-banknotes')
                ->sortable(),

            TextColumn::make('is_active')
                ->label('Status Lapangan')
                ->sortable()
                ->badge()
                ->formatStateUsing(fn (bool $state): string => $state ? 'Lapangan Tersedia' : 'Lapangan Tidak Tersedia')
                ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->iconPosition('before')
                ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
        ])
        ->filters([
            SelectFilter::make('field_id')
                ->label('Filter Lapangan')
                ->relationship('field', 'name')
                ->searchable(),

            SelectFilter::make('day_of_week')
                ->label('Filter Hari')
                ->options([
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFieldSchedules::route('/'),
            'create' => Pages\CreateFieldSchedule::route('/create'),
            'edit' => Pages\EditFieldSchedule::route('/{record}/edit'),
        ];
    }
}

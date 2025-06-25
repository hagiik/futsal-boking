<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieldResource\Pages;
use App\Filament\Resources\FieldResource\RelationManagers;
use App\Models\Field;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;
    public static ?string $navigationIcon = 'heroicon-o-building-library';
    public static ?string $navigationGroup = 'Manajemen Lapangan';
    protected static ?string $navigationLabel = 'Lapangan';
    protected static ?string $slug = 'lapangan';
    protected static ?int $navigationSort = 0;
    /*
        * Get the label for the model.
        *
        * @return string
    */
    public static function getModelLabel(): string
    {
        return 'Lapangan'; 
    }
    public static function getPluralModelLabel(): string
    {
        return 'Lapangan'; 
    }
 
public static function form(Form $form): Form
{
    return $form->schema([
        Grid::make(3)->schema([
            Group::make()
                ->schema([
                    Section::make('Informasi Umum')->schema([
                        Hidden::make('id'),
                        TextInput::make('name')
                            ->label('Nama Lapangan')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->readOnly()
                            ->unique(\App\Models\Field::class, 'slug', ignoreRecord: true)
                            ->required()
                            ->maxLength(255),

                        Select::make('field_category_id')
                            ->label('Kategori Lapangan')
                            ->relationship('category', 'name')
                            // ->searchable()
                            ->required(),
                    ])->columns(2),

                    Section::make('Detail Tambahan')->schema([
                        FileUpload::make('image')
                            ->label('Gambar Lapangan')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('lapangan')
                            ->visibility('public')
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4),
                    ]),
                ])
                ->columnSpan(2),

            Group::make()
                ->schema([
                    Section::make('Fasilitas')->schema([
                        CheckboxList::make('facilities')
                            ->label('Daftar Fasilitas')
                            ->relationship('facilities', 'name')
                            ->searchable(),
                    ]),
                ])
                ->columnSpan(1),
        ]),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(),
                TextColumn::make('category.name')->label('Kategori')->sortable(),
                TextColumn::make('schedules_days')
                    ->label('Hari Aktif')
                    ->getStateUsing(function ($record) {
                        $dayMap = [
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu',
                            'Sunday' => 'Minggu',
                        ];

                        // Ambil daftar unik hari dari relasi schedules
                        $uniqueDays = $record->schedules
                            ->pluck('day_of_week')
                            ->unique()
                            ->map(fn($day) => $dayMap[$day] ?? $day)
                            ->values()
                            ->toArray();

                        return implode(', ', $uniqueDays);
                    })
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Kelola Jadwal')
                    ->label('Kelola Jadwal')
                    ->icon('heroicon-o-calendar-days')
                    ->url(fn ($record) => route('filament.admin.resources.jadwal-lapangan.create'))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}

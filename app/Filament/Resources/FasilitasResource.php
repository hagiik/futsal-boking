<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FasilitasResource\Pages;
use App\Filament\Resources\FasilitasResource\RelationManagers;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FasilitasResource extends Resource
{
    protected static ?string $model = Facility::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    public static ?string $navigationGroup = 'Manajemen Lapangan';
    protected static ?string $navigationLabel = 'Fasilitas';
    protected static ?string $slug = 'fasilitas';
    // protected static ?int $navigationSort = 2;
    /*
        * Get the label for the model.
        *
        * @return string
    */
    public static function getModelLabel(): string
    {
        return 'Fasilitas'; 
    }
    public static function getPluralModelLabel(): string
    {
        return 'Fasilitas Lapangan'; 
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Fasilitas')
                    ->required()
                    ->maxLength(255),
                TextInput::make('icon')
                    ->label('Ikon')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Fasilitas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('icon')
                    ->label('Ikon')
                    // ->formatStateUsing(fn ($state) => '<i class="' . $state . '"></i>')
                    // ->html()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListFasilitas::route('/'),
            // 'create' => Pages\CreateFasilitas::route('/create'),
            'edit' => Pages\EditFasilitas::route('/{record}/edit'),
        ];
    }
}

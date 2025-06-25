<?php

namespace App\Filament\Resources\MembershipPointHistoriesResource\RelationManagers;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PointHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'pointHistories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Select::make('type')
                    ->options([
                        'booking' => 'Booking',
                        'bonus' => 'Bonus',
                        'promo' => 'Promo',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('points')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Jenis'),
                Tables\Columns\TextColumn::make('points')->label('Poin'),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

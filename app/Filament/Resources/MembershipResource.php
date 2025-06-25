<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipPointHistoriesResource\RelationManagers\PointHistoriesRelationManager;
use App\Filament\Resources\MembershipResource\Pages;
use App\Filament\Resources\MembershipResource\RelationManagers;
use App\Models\Membership;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    public static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Membership';
    protected static ?string $slug = 'membership';
    protected static ?int $navigationSort = 0;
    /*
        * Get the label for the model.
        *
        * @return string
    */
    public static function getModelLabel(): string
    {
        return 'Membership'; 
    }
    public static function getPluralModelLabel(): string
    {
        return 'Membership'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->required()
                    ->disabledOn('edit'), // agar tidak bisa diganti setelah dibuat

                TextInput::make('total_points')->label('Total Poin')->numeric()->required(),
                Select::make('level')->options([
                    'basic' => 'Basic',
                    'silver' => 'Silver',
                    'gold' => 'Gold',
                    'vip' => 'VIP',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Member')
                    ->searchable(),
                TextColumn::make('level')->badge()->color(fn($state) => match($state) {
                    'basic' => 'gray',
                    'silver' => 'info',
                    'gold' => 'warning',
                    'vip' => 'success',
                }),
                TextColumn::make('total_points')->label('Poin')->sortable(),
                TextColumn::make('created_at')->label('Terdaftar')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            PointHistoriesRelationManager::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
            'view' => Pages\ViewMembership::route('/{record}'),
        ];
    }
}

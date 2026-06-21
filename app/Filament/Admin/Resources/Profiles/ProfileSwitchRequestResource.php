<?php

namespace App\Filament\Admin\Resources\Profiles;

use App\Filament\Admin\Resources\BaseAdminResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\\Models\\ProfileSwitchRequest;

class ProfileSwitchRequestResource extends BaseAdminResource
{
    protected static ?string $model = ProfileSwitchRequest::class;

    protected static ?string $navigationGroup = 'Profiles';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Details')
                ->schema([
                    Forms\Components\TextInput::make('name')->maxLength(255),
                    Forms\Components\Textarea::make('notes')->columnSpanFull(),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfileSwitchRequests::route('/'),
            'create' => Pages\CreateProfileSwitchRequest::route('/create'),
            'view' => Pages\ViewProfileSwitchRequest::route('/{record}'),
            'edit' => Pages\EditProfileSwitchRequest::route('/{record}/edit'),
        ];
    }
}

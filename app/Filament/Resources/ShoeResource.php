<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Shoe;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ShoeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShoeResource\RelationManagers;

class ShoeResource extends Resource
{
    protected static ?string $model = Shoe::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->placeholder('Enter the name of the shoe')
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->placeholder('Enter the price of the shoe')
                            ->numeric()
                            ->prefix('IDR'),
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->required()
                            ->placeholder('Upload the thumbnail of the shoe')
                            ->image(),
                        Repeater::make('photos')
                            ->relationship('photos')
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Image')
                                    ->required()
                                    ->placeholder('Upload an image')
                                    ->image(),
                            ]),

                        Repeater::make('sizes')
                            ->relationship('sizes')
                            ->schema([
                                TextInput::make('size')
                                    ->label('Size')
                                    ->required()
                                    ->placeholder('Enter the size of the shoe')
                                    ->numeric(),
                            ]),
                    ]),

                Fieldset::make('Additional')
                    ->schema([
                        Textarea::make('about')
                            ->required(),
                        Select::make('is_popular')
                            ->label('Is Popular')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->default(0)
                            ->required(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('stock')
                            ->label('Stock')
                            ->required()
                            ->placeholder('Enter the stock of the shoe')
                            ->prefix('Qty')
                            ->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category.name'),
                TextColumn::make('thumbnail'),
                IconColumn::make('is_popular')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('popular')
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->placeholder('All Categories'),
                SelectFilter::make('brand_id')
                    ->relationship('brand', 'name')
                    ->label('Brand')
                    ->placeholder('All Brand'),
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
            'index' => Pages\ListShoes::route('/'),
            'create' => Pages\CreateShoe::route('/create'),
            'edit' => Pages\EditShoe::route('/{record}/edit'),
        ];
    }
}

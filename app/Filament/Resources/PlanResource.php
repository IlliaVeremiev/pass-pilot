<?php

namespace App\Filament\Resources;

use App\Models\Plan;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Plans';

    protected static ?string $modelLabel = 'Plan';

    protected static ?string $pluralModelLabel = 'Plans';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Plan Name')
                            ->placeholder('Enter plan name')
                            ->columnSpan(2),

                        TextInput::make('description')
                            ->maxLength(500)
                            ->label('Description')
                            ->placeholder('Enter plan description')
                            ->columnSpan(2),

                        TextInput::make('price')
                            ->label('Price')
                            ->prefix('$')
                            ->minValue(0)
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('duration')
                            ->label('Duration')
                            ->placeholder('Duration iin days')
                            ->numeric()
                            ->minValue(0)
                            ->step(1)
                            ->required()
                            ->columnSpan(1),

                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive plans will not be displayed')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Status')
                    ->placeholder('All Plans')
                    ->trueLabel('Active Plans')
                    ->falseLabel('Inactive Plans'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Plan')
                    ->size('xl'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([50, 100, 200])
            ->defaultPaginationPageOption(50);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PlanResource\Pages\ListPlans::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Subscription Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}

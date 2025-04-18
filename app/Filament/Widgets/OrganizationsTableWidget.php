<?php

namespace App\Filament\Widgets;

use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class OrganizationsTableWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Organization::query()
                    ->where('owner_id', Auth::id())
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Members')
                    ->counts('users')
                    ->sortable(),
            ])
            ->paginated(false)
            ->defaultPaginationPageOption(PHP_INT_MAX)
            ->actions([
                Tables\Actions\Action::make('Open')
                    ->link()
                    ->action(fn (Organization $record) => redirect()->to(Filament::getPanel('organization')->getUrl($record))),
            ])
            ->emptyStateHeading('No organizations found')
            ->emptyStateDescription('Create your first organization to get started.');
    }
}

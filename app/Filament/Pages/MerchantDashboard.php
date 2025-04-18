<?php

namespace App\Filament\Pages;

use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;

class MerchantDashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $title = 'Select organization';

    protected static string $view = 'filament.pages.merchant-dashboard';

    protected function getActions(): array
    {
        return [
            $this->createOrganizationAction(),
        ];
    }

    private function createOrganizationAction(): Action
    {
        return Action::make('createOrganization')
            ->label('Create New Organization')
            ->color('primary')
            ->modalHeading('Create New Organization')
            ->modalWidth('md')
            ->form([
                TextInput::make('name')
                    ->label('Organization Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter organization name'),

                Textarea::make('description')
                    ->label('Description (Optional)')
                    ->maxLength(500)
                    ->placeholder('Enter a brief description of your organization'),
            ])
            ->action(function (array $data) {
                $organization = Organization::create([
                    'name' => $data['name'],
                    'description' => $data['description'] ?? null,
                    'owner_id' => Auth::id(),
                ]);

                Notification::make()
                    ->title('Organization Created')
                    ->body("Organization {$organization->name} has been created")
                    ->success()
                    ->send();

                return redirect()->to(Filament::getPanel('organization')->getUrl($organization));
            });
    }
}

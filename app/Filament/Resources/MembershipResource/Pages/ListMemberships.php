<?php

namespace App\Filament\Resources\MembershipResource\Pages;

use App\Filament\Resources\MembershipResource;
use App\Http\Dto\Membership\CreateMembershipDto;
use App\Utils\Container;
use App\Utils\Timezones;
use DateTimeInterface;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;

class ListMemberships extends ListRecords
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Membership')
                ->size('xl')
                ->modalHeading('Create New Membership')
                ->mutateFormDataUsing(function ($data) {
                    $data['start_at'] = Carbon::parse($data['start_at'])
                        ->setTimezone(Timezones::COPENHAGEN)
                        ->startOfDay()
                        ->format(DateTimeInterface::ATOM);
                    $data['end_at'] = Carbon::parse($data['end_at'])
                        ->setTimezone(Timezones::COPENHAGEN)
                        ->endOfDay()
                        ->format(DateTimeInterface::ATOM);

                    return $data;
                })
                ->action(function (Actions\CreateAction $action, $data): void {
                    try {
                        Container::membershipService()->createMembership(CreateMembershipDto::from($data));
                    } finally {
                        // TODO: Temporary solution.
                        // Show success even in case email not found.
                        // Invitation email should be sent instead
                        $action->success();
                    }
                }),
        ];
    }
}

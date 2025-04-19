<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipResource\Pages;
use App\Models\Membership;
use App\Utils\Container;
use App\Utils\Timezones;
use Carbon\Carbon;
use DateTimeInterface;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Memberships';

    protected static ?string $modelLabel = 'Membership';

    protected static ?string $pluralModelLabel = 'Memberships';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('user_email')
                            ->label('User Email')
                            ->email()
                            ->required()
                            ->columnSpan(2),

                        Select::make('plan_id')
                            ->label('Plan')
                            ->relationship(
                                'plan',
                                'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('organization_id', Filament::getTenant()->id)
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(2)
                            ->live()
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::updateEndAt($set, $get)),

                        DateTimePicker::make('start_at')
                            ->label('Start Date')
                            ->default(now(Timezones::COPENHAGEN)->startOfDay()->format(DateTimeInterface::ATOM))
                            ->required()
                            ->format(DateTimeInterface::ATOM)
                            ->time(false)
                            ->timezone(Timezones::COPENHAGEN)
                            ->native(false)
                            ->columnSpan(1)
                            ->live()
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::updateEndAt($set, $get)),

                        DateTimePicker::make('end_at')
                            ->label('End Date')
                            ->readOnly()
                            ->format(DateTimeInterface::ATOM)
                            ->time(false)
                            ->timezone(Timezones::COPENHAGEN)
                            ->native(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    private static function updateEndAt(Set $set, Get $get): void
    {
        $planId = $get('plan_id');
        $startAt = $get('start_at');
        if (! $planId || ! $startAt) {
            return;
        }

        $plan = Container::planRepository()->findById($planId);
        if ($plan) {
            $startDate = Carbon::parse($startAt, Timezones::COPENHAGEN)->startOfDay();
            $endDate = $startDate->addDays($plan->duration - 1)->endOfDay();
            $set('end_at', $endDate->format(DateTimeInterface::ATOM));
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_at')
                    ->label('Start Date')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),

                TextColumn::make('end_at')
                    ->label('End Date')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Membership')
                    ->size('xl'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([50, 100, 200])
            ->defaultPaginationPageOption(50);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Subscription Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
}

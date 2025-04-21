<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Models\Venue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Venues';

    protected static ?string $modelLabel = 'Venue';

    protected static ?string $pluralModelLabel = 'Venues';

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
                            ->label('Venue Name')
                            ->placeholder('Enter venue name')
                            ->columnSpan(2),

                        TextInput::make('address')
                            ->maxLength(255)
                            ->label('Address')
                            ->placeholder('Enter venue address')
                            ->columnSpan(2),

                        Toggle::make('active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive venues will not be displayed to customers')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                FileUpload::make('image')
                    ->image()
                    ->label('Venue Image')
                    ->helperText('Upload a venue image (JPG, PNG). Max size: 5MB')
                    ->maxSize(5120)
                    ->disk('minio')
                    ->directory('venues')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->imagePreviewHeight('250')
                    ->imageResizeMode('cover')
                    ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) {
                        $filename = Str::uuid() . '.webp';
                        $directory = 'venues';
                        $manager = new ImageManager(new Driver);
                        $image = $manager->read($file->getRealPath());
                        $image = $image->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $imageData = $image->toWebp(95)->toFilePointer();

                        Storage::disk('minio')->put(
                            "{$directory}/{$filename}",
                            $imageData,
                            'public'
                        );

                        return "{$directory}/{$filename}";
                    })
                    ->columnSpan('full'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('minio')
                    ->circular(false)
                    ->square()
                    ->defaultImageUrl(url('/images/venue-placeholder.png')),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

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
                    ->placeholder('All Venues')
                    ->trueLabel('Active Venues')
                    ->falseLabel('Inactive Venues'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Venue')
                    ->size('xl'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([50, 100, 200])
            ->defaultPaginationPageOption(50);
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
            'index' => Pages\ListVenues::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Venue Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}

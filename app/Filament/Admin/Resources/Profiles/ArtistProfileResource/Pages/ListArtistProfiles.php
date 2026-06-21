<?php

namespace App\Filament\Admin\Resources\Profiles\ArtistProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\ArtistProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistProfiles extends ListRecords
{
    protected static string $resource = ArtistProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Profiles\ArtistProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\ArtistProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArtistProfile extends ViewRecord
{
    protected static string $resource = ArtistProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Profiles\PersonalProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\PersonalProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonalProfiles extends ListRecords
{
    protected static string $resource = PersonalProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

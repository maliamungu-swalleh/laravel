<?php

namespace App\Filament\Admin\Resources\Profiles\PersonalProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\PersonalProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalProfile extends ViewRecord
{
    protected static string $resource = PersonalProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

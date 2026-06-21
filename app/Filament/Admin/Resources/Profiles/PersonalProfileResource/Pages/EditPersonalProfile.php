<?php

namespace App\Filament\Admin\Resources\Profiles\PersonalProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\PersonalProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalProfile extends EditRecord
{
    protected static string $resource = PersonalProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

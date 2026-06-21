<?php

namespace App\Filament\Admin\Resources\Profiles\ProfileSwitchRequestResource\Pages;

use App\Filament\Admin\Resources\Profiles\ProfileSwitchRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProfileSwitchRequest extends ViewRecord
{
    protected static string $resource = ProfileSwitchRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

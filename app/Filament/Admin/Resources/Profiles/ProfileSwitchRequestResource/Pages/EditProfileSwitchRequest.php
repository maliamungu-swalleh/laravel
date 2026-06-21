<?php

namespace App\Filament\Admin\Resources\Profiles\ProfileSwitchRequestResource\Pages;

use App\Filament\Admin\Resources\Profiles\ProfileSwitchRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfileSwitchRequest extends EditRecord
{
    protected static string $resource = ProfileSwitchRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource\Pages;

use App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlueCheckVerification extends ViewRecord
{
    protected static string $resource = BlueCheckVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

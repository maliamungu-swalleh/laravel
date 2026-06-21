<?php

namespace App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource\Pages;

use App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlueCheckVerification extends EditRecord
{
    protected static string $resource = BlueCheckVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Verification\VerificationRequestResource\Pages;

use App\Filament\Admin\Resources\Verification\VerificationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVerificationRequest extends ViewRecord
{
    protected static string $resource = VerificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

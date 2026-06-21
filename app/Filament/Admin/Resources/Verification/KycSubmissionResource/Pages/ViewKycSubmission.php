<?php

namespace App\Filament\Admin\Resources\Verification\KycSubmissionResource\Pages;

use App\Filament\Admin\Resources\Verification\KycSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKycSubmission extends ViewRecord
{
    protected static string $resource = KycSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

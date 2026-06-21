<?php

namespace App\Filament\Admin\Resources\Verification\VerificationRequestResource\Pages;

use App\Filament\Admin\Resources\Verification\VerificationRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVerificationRequests extends ListRecords
{
    protected static string $resource = VerificationRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

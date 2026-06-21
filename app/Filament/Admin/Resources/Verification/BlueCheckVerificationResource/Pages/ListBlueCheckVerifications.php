<?php

namespace App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource\Pages;

use App\Filament\Admin\Resources\Verification\BlueCheckVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlueCheckVerifications extends ListRecords
{
    protected static string $resource = BlueCheckVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

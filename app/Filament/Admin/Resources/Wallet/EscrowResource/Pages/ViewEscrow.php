<?php

namespace App\Filament\Admin\Resources\Wallet\EscrowResource\Pages;

use App\Filament\Admin\Resources\Wallet\EscrowResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEscrow extends ViewRecord
{
    protected static string $resource = EscrowResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

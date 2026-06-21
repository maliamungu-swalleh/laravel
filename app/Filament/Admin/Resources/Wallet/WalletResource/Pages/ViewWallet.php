<?php

namespace App\Filament\Admin\Resources\Wallet\WalletResource\Pages;

use App\Filament\Admin\Resources\Wallet\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWallet extends ViewRecord
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

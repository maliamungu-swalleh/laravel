<?php

namespace App\Filament\Admin\Resources\Wallet\WalletTransactionResource\Pages;

use App\Filament\Admin\Resources\Wallet\WalletTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWalletTransactions extends ListRecords
{
    protected static string $resource = WalletTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

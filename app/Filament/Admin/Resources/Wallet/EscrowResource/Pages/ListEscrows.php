<?php

namespace App\Filament\Admin\Resources\Wallet\EscrowResource\Pages;

use App\Filament\Admin\Resources\Wallet\EscrowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEscrows extends ListRecords
{
    protected static string $resource = EscrowResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

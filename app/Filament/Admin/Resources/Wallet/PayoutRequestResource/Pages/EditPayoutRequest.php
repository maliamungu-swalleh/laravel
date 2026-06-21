<?php

namespace App\Filament\Admin\Resources\Wallet\PayoutRequestResource\Pages;

use App\Filament\Admin\Resources\Wallet\PayoutRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayoutRequest extends EditRecord
{
    protected static string $resource = PayoutRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

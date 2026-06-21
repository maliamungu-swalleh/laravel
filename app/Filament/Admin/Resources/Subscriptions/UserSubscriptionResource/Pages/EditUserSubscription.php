<?php

namespace App\Filament\Admin\Resources\Subscriptions\UserSubscriptionResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\UserSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserSubscription extends EditRecord
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

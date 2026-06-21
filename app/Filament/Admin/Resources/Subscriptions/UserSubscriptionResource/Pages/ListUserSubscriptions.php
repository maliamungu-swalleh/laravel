<?php

namespace App\Filament\Admin\Resources\Subscriptions\UserSubscriptionResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\UserSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserSubscriptions extends ListRecords
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

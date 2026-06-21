<?php

namespace App\Filament\Admin\Resources\Subscriptions\SubscriptionPlanResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\SubscriptionPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionPlan extends EditRecord
{
    protected static string $resource = SubscriptionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

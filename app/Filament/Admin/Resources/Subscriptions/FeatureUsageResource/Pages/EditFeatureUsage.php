<?php

namespace App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeatureUsage extends EditRecord
{
    protected static string $resource = FeatureUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

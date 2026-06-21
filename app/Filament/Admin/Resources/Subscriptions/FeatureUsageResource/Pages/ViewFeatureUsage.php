<?php

namespace App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFeatureUsage extends ViewRecord
{
    protected static string $resource = FeatureUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

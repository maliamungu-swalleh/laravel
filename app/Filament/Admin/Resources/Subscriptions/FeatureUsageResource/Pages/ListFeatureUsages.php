<?php

namespace App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource\Pages;

use App\Filament\Admin\Resources\Subscriptions\FeatureUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeatureUsages extends ListRecords
{
    protected static string $resource = FeatureUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCampaignApplication extends ViewRecord
{
    protected static string $resource = CampaignApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

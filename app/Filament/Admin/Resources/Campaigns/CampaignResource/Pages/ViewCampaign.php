<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCampaign extends ViewRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

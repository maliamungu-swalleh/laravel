<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampaignApplications extends ListRecords
{
    protected static string $resource = CampaignApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

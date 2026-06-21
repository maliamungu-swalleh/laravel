<?php

namespace App\Filament\Admin\Resources\Campaigns\SubCampaignResource\Pages;

use App\Filament\Admin\Resources\Campaigns\SubCampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubCampaigns extends ListRecords
{
    protected static string $resource = SubCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

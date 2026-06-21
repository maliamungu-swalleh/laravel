<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignSubmissionResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampaignSubmissions extends ListRecords
{
    protected static string $resource = CampaignSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

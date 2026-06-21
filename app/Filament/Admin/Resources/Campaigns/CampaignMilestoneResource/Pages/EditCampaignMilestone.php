<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignMilestoneResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignMilestoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaignMilestone extends EditRecord
{
    protected static string $resource = CampaignMilestoneResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

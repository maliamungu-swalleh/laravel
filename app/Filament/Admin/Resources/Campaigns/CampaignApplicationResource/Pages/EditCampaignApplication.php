<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaignApplication extends EditRecord
{
    protected static string $resource = CampaignApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

<?php

namespace App\Filament\Admin\Resources\Campaigns\SubCampaignResource\Pages;

use App\Filament\Admin\Resources\Campaigns\SubCampaignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubCampaign extends EditRecord
{
    protected static string $resource = SubCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

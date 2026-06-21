<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignInvitationResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCampaignInvitations extends ListRecords
{
    protected static string $resource = CampaignInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}

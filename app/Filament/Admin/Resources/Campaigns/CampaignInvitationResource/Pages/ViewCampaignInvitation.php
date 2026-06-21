<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignInvitationResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCampaignInvitation extends ViewRecord
{
    protected static string $resource = CampaignInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }
}

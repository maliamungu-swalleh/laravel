<?php

namespace App\Filament\Admin\Resources\Campaigns\CampaignSubmissionResource\Pages;

use App\Filament\Admin\Resources\Campaigns\CampaignSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaignSubmission extends EditRecord
{
    protected static string $resource = CampaignSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

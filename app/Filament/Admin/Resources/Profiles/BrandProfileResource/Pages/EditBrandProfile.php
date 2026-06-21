<?php

namespace App\Filament\Admin\Resources\Profiles\BrandProfileResource\Pages;

use App\Filament\Admin\Resources\Profiles\BrandProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrandProfile extends EditRecord
{
    protected static string $resource = BrandProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}

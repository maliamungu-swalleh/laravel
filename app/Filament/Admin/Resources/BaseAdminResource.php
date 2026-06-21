<?php

namespace App\Filament\Admin\Resources;

use Filament\Resources\Resource;

abstract class BaseAdminResource extends Resource
{
    protected static ?string $navigationGroup = 'Platform';
}

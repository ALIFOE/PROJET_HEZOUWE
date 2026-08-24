<?php

namespace App\Support;

use App\Models\Partner;
use Illuminate\Support\Collection;

class PartnerCatalog
{
    public static function all(): Collection
    {
        return Partner::orderBy('order')->orderBy('id')->get()->map(fn ($p) => $p->toArray());
    }
}

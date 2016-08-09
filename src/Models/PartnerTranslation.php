<?php

namespace TypiCMS\Modules\Partners\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class PartnerTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Partners\Shells\Models\Partner', 'partner_id')->withoutGlobalScopes();
    }
}

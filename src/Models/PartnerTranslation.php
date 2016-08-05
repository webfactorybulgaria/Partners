<?php

namespace TypiCMS\Modules\Partners\Models;

use TypiCMS\Modules\Core\Custom\Models\BaseTranslation;

class PartnerTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Partners\Custom\Models\Partner', 'partner_id')->withoutGlobalScopes();
    }
}

<?php

namespace TypiCMS\Modules\Partners\Models;

use TypiCMS\Modules\Core\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Partner extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Partners\Presenters\ModulePresenter';

    protected $fillable = [
        'image',
        'position',
        'homepage',
        // Translatable columns
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'website',
        'summary',
        'body',
    ];

    protected $appends = ['thumb'];

}

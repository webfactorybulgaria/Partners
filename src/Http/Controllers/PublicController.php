<?php

namespace TypiCMS\Modules\Partners\Http\Controllers;

use TypiCMS\Modules\Core\Custom\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Partners\Custom\Repositories\PartnerInterface;

class PublicController extends BasePublicController
{
    public function __construct(PartnerInterface $partner)
    {
        parent::__construct($partner, 'partners');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all();

        return view('partners::public.index')
            ->with(compact('models'));
    }

    /**
     * Show news.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('partners::public.show')
            ->with(compact('model'));
    }
}

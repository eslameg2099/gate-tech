<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var array
     */
    public $breadcrumbs = [];

    /**
     * @var array
     */
    public $bodyClass = '';

    /**
     * Create a new component instance.
     *
     * @param null $title
     * @param array $breadcrumbs
     */
    public function __construct($title = null, $breadcrumbs = [], $bodyClass = '')
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
        $this->bodyClass = $bodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('dashboard::master');
    }
}

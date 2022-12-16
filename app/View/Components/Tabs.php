<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $latest;
    public $popular;
    public $tab;
    public function __construct($latest, $popular, $tab)
    {
        $this->latest = $latest;
        $this->popular = $popular;
        $this->tab = $tab;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tabs');
    }
}

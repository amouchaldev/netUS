<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Communities extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public $id;
    public $communities;
    public function __construct($communities)
    {
        $this->communities = $communities;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.communities');
    }
}

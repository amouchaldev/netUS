<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CommunityCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public $name;
    // public $description;
    // public $slug;
    // public $followers;
    public $community;
    public function __construct($community)
    {
        // $this->name = $name;
        // $this->description = $description;
        // $this->slug = $slug;
        // $this->followers = $followers;
        $this->community = $community;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.community-card');
    }
}

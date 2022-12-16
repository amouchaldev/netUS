<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $post;
    public $community;
    public function __construct($post, $community = null)
    {
        $this->post = $post;
        $this->community = $community;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-card');
    }
}

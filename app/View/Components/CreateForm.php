<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreateForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $route;
    public $method;
    public $post;
    public function __construct($type = 'comment', $route = 'posts.store', $method = 'POST', $post = null)
    {
        $this->type = $type;
        $this->route = $route;
        $this->method = $method;
        $this->post = $post;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.create-form');
    }
}

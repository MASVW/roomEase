<?php

namespace App\Livewire;

use Livewire\Component;

class NavComponent extends Component
{
    public $menu = "";
    public $title = "";
    public function mount()
    {
        $menu = session()->get('menu');
        if (is_null($menu))
        {
            $this->title == "" ? $this->menu = "Home" : $this->menu = $this->title ;
        }
        else {
            $this->title = $menu;
            $this->menu = $menu;
        }
    }

    public function redirectHome()
    {
        session()->put('menu', 'Home');
        return redirect('/');
    }

    public function redirectMyApplication()
    {
        session()->put('menu', 'My Application');
        return redirect('/');
    }
    public function redirectDocumentation()
    {
        session()->put('menu', 'Documentation');
        return redirect('/how-to-book');
    }

    public function render()
    {
        return view('livewire.nav-component');
    }

}

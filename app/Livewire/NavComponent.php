<?php

namespace App\Livewire;

use Livewire\Component;

class NavComponent extends Component
{
    public $menu = "";
    public function mount()
    {
        $menu = session()->get('menu');
        if (is_null($menu))
        {
            $this->menu = "Home";
        }
        else { $this->menu = $menu; }
    }

    public function redirectHome()
    {
        session()->flash('menu', 'Home');
        return redirect('/');
    }

    public function redirectMyApplication()
    {
        session()->flash('menu', 'My Application');
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.nav-component');
    }

}

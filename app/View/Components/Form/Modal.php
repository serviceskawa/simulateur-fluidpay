<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Modal extends Component
{
    public string $id;
    public ?string $title;

    public function __construct(string $id, ?string $title = 'Modal Title')
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.form.modal');
    }
}

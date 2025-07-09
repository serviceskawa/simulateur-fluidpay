<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public string $name;
    public ?string $label;
    public string $type;
    public ?string $placeholder;

    public function __construct(string $name, ?string $label = null, string $type = 'text', ?string $placeholder = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.form.input');
    }
}

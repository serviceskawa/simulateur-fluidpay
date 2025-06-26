<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Button extends Component
{
    public ?string $type;
    public ?string $icon;
    public ?string $iconPosition;

    public function __construct(
        ?string $type = 'submit',
        ?string $icon = null,
        ?string $iconPosition = 'start'
    ) {
        $this->type = $type;
        $this->icon = $icon;
        $this->iconPosition = $iconPosition;
    }

    public function render()
    {
        return view('components.form.button');
    }
}

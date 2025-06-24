<?php
namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $name;
    public ?string $label;

    public function __construct(string $name, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.form.checkbox');
    }
}

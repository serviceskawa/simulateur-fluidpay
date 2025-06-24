<?php
namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public ?string $label;
    public array $options;

    public function __construct(string $name, array $options, ?string $label = null)
    {
        $this->name = $name;
        $this->options = $options;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.form.select');
    }
}

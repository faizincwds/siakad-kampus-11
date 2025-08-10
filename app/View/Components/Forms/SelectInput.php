<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInput extends Component
{
    public string $id;
    public string $name;
    public string $value; // Nilai yang saat ini dipilih
    public array $options; // Array asosiatif untuk opsi dropdown (value => label)

    /**
     * Buat instance komponen baru.
     */
    public function __construct(string $id, string $name, $value = null, array $options = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = old($name, $value ?? ''); // Ini untuk memastikan nilai lama tetap ada
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.forms.select-input');
    }
}

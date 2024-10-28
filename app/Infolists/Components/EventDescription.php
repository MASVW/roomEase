<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\Entry;

class EventDescription extends Entry
{
    protected string $view = 'infolists.components.event-description';

    public function maxLength(int | \Closure | null $maxLength): static
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->evaluate($this->maxLength);
    }
}

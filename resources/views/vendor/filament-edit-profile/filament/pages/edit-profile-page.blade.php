<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    @foreach ($this->getRegisteredCustomProfileComponents() as $component)
        @unless(is_null($component))
            @livewire($component)
        @endunless
    @endforeach
</x-filament-panels::page>
<?php 

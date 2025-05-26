<?php

declare(strict_types=1);

?>
<x-filament::section aside>
    <x-slot name="heading">
        {{ __('filament-edit-profile::default.token_section_title') }}
    </x-slot>
    <x-slot name="description">
        {{ __('filament-edit-profile::default.token_section_description') }}
    </x-slot>

    {{ $this->table }}
</x-filament::section>

<?php 

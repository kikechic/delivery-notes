<?php

namespace Kikechi\DeliveryNotes\Commands;

use Illuminate\Console\Command;

class InstallDeliveryNoteCommand extends Command
{
    protected $signature = 'delivery-notes:install';

    protected $description = 'Install all of the delivery notes resources';

    public function handle(): void
    {
        $this->comment('Publishing delivery notes assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.assets']);

        $this->comment('Publishing delivery notes views...');
        $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.views']);

        $this->comment('Publishing delivery notes translations...');
        $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.translations']);

        $this->comment('Publishing delivery notes config...');
        $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.config']);

        $this->info('Delivery notes scaffolding installed successfully.');
    }
}
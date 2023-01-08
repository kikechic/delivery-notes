<?php

namespace Kikechi\DeliveryNotes\Commands;

use Illuminate\Console\Command;

class UpdateDeliveryNoteCommand extends Command
{
    protected $signature = 'delivery-notes:update';

    protected $description = 'Update delivery notes views and translations';

    public function handle(): void
    {
        $this->info('This will overwrite default templates and translations.');

        if ($this->confirm('Do you wish to continue?')) {
            $this->comment('Updating delivery notes views...');
            $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.views', '--force' => true]);

            $this->comment('Updating delivery notes translations...');
            $this->callSilent('vendor:publish', ['--tag' => 'delivery-notes.translations', '--force' => true]);

            $this->info('Delivery notes views and translations updated successfully.');
        }
    }
}
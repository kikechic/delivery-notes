<?php

namespace Kikechi\DeliveryNotes\Traits;

use Illuminate\Support\Facades\Storage;

trait DeliveryNoteSavesFiles
{
    public string $disk;

    public function save(string $disk = ''): self
    {
        if ($disk !== '') {
            $this->disk = $disk;
        }

        $this->render();

        Storage::disk($this->disk)->put($this->filename, $this->output);

        return $this;
    }

    /**
     * @return mixed
     */
    public function url()
    {
        return Storage::disk($this->disk)->url($this->filename);
    }
}
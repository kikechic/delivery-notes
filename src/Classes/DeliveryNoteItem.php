<?php


namespace Kikechi\DeliveryNotes\Classes;

use Exception;

class DeliveryNoteItem
{
    public string $title;

    public string|bool $description = false;

    public string|null $units;

    public float $quantity;

    public function __construct()
    {
        $this->quantity = 0.0;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function units(string $units): self
    {
        $this->units = $units;

        return $this;
    }

    public function quantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function hasUnits(): bool
    {
        return !is_null($this->units);
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (!$this->title) {
            throw new Exception('DeliveryNoteItem: title not defined.');
        }
    }
}
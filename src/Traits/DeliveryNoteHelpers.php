<?php

namespace Kikechi\DeliveryNotes\Traits;

use Exception;
use Illuminate\Support\Str;
use Kikechi\DeliveryNotes\Classes\DeliveryNoteParty;

trait DeliveryNoteHelpers
{
    /**
     * @return $this
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function status(string|null $status)
    {
        $this->status = $status;

        return $this;
    }

    public function notes(string $notes)
    {
        $this->notes = $notes;

        return $this;
    }

    public function logo(string $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return $this
     */
    public function seller(DeliveryNoteParty $seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * @return $this
     */
    public function buyer(DeliveryNoteParty $buyer)
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @param mixed
     * @param mixed $value
     *
     * @return $this
     */
    public function setCustomData($value)
    {
        $this->userDefinedData = $value;

        return $this;
    }

    public function getCustomData()
    {
        return $this->userDefinedData;
    }

    /**
     * @return $this
     */
    public function template(string $template = 'default')
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return $this
     */
    public function filename(string $filename)
    {
        $this->filename = sprintf('%s.pdf', $filename);

        return $this;
    }

    public function getLogo()
    {
        $type = pathinfo($this->logo, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logo);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function applyColspan(): void
    {
        (!$this->hasItemUnits) ?: $this->table_columns++;
    }

    /**
     * @return string
     */
    protected function getDefaultFilename(string $name)
    {
        if ($name === '') {
            return sprintf('%s_%s', $this->series, $this->sequence);
        }

        return sprintf('%s_%s_%s', Str::snake($name), $this->series, $this->sequence);
    }

    /**
     * @throws Exception
     */
    protected function beforeRender(): void
    {
        $this->validate();
        $this->calculate();
    }

    /**
     * @throws Exception
     */
    protected function validate()
    {
        if (!$this->buyer) {
            throw new Exception('Buyer not defined.');
        }

        if (!$this->seller) {
            throw new Exception('Seller not defined.');
        }

        if (!count($this->items)) {
            throw new Exception('No items to delivery note defined.');
        }
    }

    /**
     * @return $this
     */
    protected function calculate()
    {
        $this->items->each(function ($item) {
            !$item->hasUnits() || ($this->hasItemUnits = true);
        });
        
        $this->applyColspan();

        return $this;
    }
}
<?php

namespace Kikechi\DeliveryNotes\Classes;

use Kikechi\DeliveryNotes\Contracts\DeliveryNotePartyContract;

class DeliveryNoteParty implements DeliveryNotePartyContract
{
    public array $custom_fields;

    /**
     * Party constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->custom_fields = [];

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
}
<?php

namespace Kikechi\DeliveryNotes\Classes;

use Kikechi\DeliveryNotes\Contracts\DeliveryNotePartyContract;

class DeliveryNoteSeller implements DeliveryNotePartyContract
{
    public mixed $name;

    public mixed $address;

    public mixed $code;

    public mixed $vat;

    public mixed $phone;

    public mixed $custom_fields;

    /**
     * Seller constructor.
     */
    public function __construct()
    {
        $this->name          = config('delivery-notes.seller.attributes.name');
        $this->address       = config('delivery-notes.seller.attributes.address');
        $this->code          = config('delivery-notes.seller.attributes.code');
        $this->vat           = config('delivery-notes.seller.attributes.vat');
        $this->phone         = config('delivery-notes.seller.attributes.phone');
        $this->custom_fields = config('delivery-notes.seller.attributes.custom_fields');
    }
}
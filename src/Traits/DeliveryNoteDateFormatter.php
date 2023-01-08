<?php

namespace Kikechi\DeliveryNotes\Traits;

use Carbon\Carbon;

trait DeliveryNoteDateFormatter
{
    /**
     * @var Carbon
     */
    public $date;

    /**
     * @var string
     */
    public $date_format;

    /**
     * @param Carbon $date
     * @return $this
     */
    public function date(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function dateFormat(string $format)
    {
        $this->date_format = $format;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date->format($this->date_format);
    }
}
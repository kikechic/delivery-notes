<?php

namespace Kikechi\DeliveryNotes;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Kikechi\DeliveryNotes\Classes\DeliveryNoteItem;
use Kikechi\DeliveryNotes\Classes\DeliveryNoteParty;
use Kikechi\DeliveryNotes\Traits\DeliveryNoteDateFormatter;
use Kikechi\DeliveryNotes\Traits\DeliveryNoteHelpers;
use Kikechi\DeliveryNotes\Traits\DeliveryNoteSavesFiles;
use Kikechi\DeliveryNotes\Traits\DeliveryNoteSerialNumberFormatter;

class DeliveryNote
{
    use DeliveryNoteHelpers;
    use DeliveryNoteSavesFiles;
    use DeliveryNoteSerialNumberFormatter;
    use DeliveryNoteDateFormatter;

    public const TABLE_COLUMNS = 4;

    /**
     * @var string
     */
    public $name;

    /**
     * @var DeliveryNotePartyContract
     */
    public $seller;

    /**
     * @var DeliveryNotePartyContract
     */
    public $buyer;

    /**
     * @var Collection
     */
    public $items;

    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var string
     */
    public $notes;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $logo;


    /**
     * @var bool
     */
    public bool $hasItemUnits;

    /**
     * @var int
     */
    public int $table_columns;

    /**
     * @var Pdf
     */
    public $pdf;

    /**
     * @var string
     */
    public string $output;

    /**
     * @var mixed
     */
    protected $userDefinedData;

    /**
     * Invoice constructor.
     *
     * @param string $name
     *
     * @throws BindingResolutionException
     */
    public function __construct(string $name = '')
    {
        // Invoice
        $this->name     = $name ?: __('delivery-notes::delivery-note.delivery-note');
        $this->seller   = app()->make(config('delivery-notes.seller.class'));
        $this->items    = Collection::make([]);
        $this->template = 'default';

        // Date
        $this->date = Carbon::now();
        $this->date_format = config('delivery-notes.date.format');

        // Serial Number
        $this->series = config('delivery-notes.serial_number.series');
        $this->sequence_padding = config('delivery-notes.serial_number.sequence_padding');
        $this->delimiter = config('delivery-notes.serial_number.delimiter');
        $this->serial_number_format = config('delivery-notes.serial_number.format');
        $this->sequence(config('delivery-notes.serial_number.sequence'));

        // Filename
        $this->filename($this->getDefaultFilename($this->name));

        $this->disk          = config('delivery-notes.disk');
        $this->table_columns = static::TABLE_COLUMNS;
    }

    /**
     * @param string $name
     *
     * @return DeliveryNote
     *@throws BindingResolutionException
     *
     */
    public static function make(string $name = ''): DeliveryNote
    {
        return new static($name);
    }

    public static function makeParty(array $attributes = [])
    {
        return new DeliveryNoteParty($attributes);
    }

    public static function makeItem(string $title = ''): DeliveryNoteItem
    {
        return (new DeliveryNoteItem())->title($title);
    }

    public function addItem(DeliveryNoteItem $item): self
    {
        $this->items->push($item);

        return $this;
    }

    public function addItems($items): self
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @throws Exception
     *
     * @return $this
     */
    public function render(): self
    {
        if ($this->pdf) {
            return $this;
        }

        $this->beforeRender();

        $template = sprintf('delivery-notes::templates.%s', $this->template);
        $view     = View::make($template, ['delivery-note' => $this]);
        $html     = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $this->pdf    = Pdf::setOption(['enable_php' => true])->loadHtml($html);
        $this->output = $this->pdf->output();

        return $this;
    }

    public function toHtml()
    {
        $template = sprintf('delivery-notes::templates.%s', $this->template);

        return View::make($template, ['delivery-note' => $this]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function stream()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->filename . '"',
        ]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function download()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->filename . '"',
            'Content-Length'      => strlen($this->output),
        ]);
    }
}

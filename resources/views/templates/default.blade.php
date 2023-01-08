<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $deliveryNote->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4, .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4, .h4 {
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }
        * {
            font-family: "DejaVu Sans", serif;
        }
        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }
        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }
        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }
        .border-0 {
            border: none !important;
        }
        .cool-gray {
            color: #6B7280;
        }
    </style>
</head>

<body>
{{-- Header --}}
@if($deliveryNote->logo)
    <img src="{{ $deliveryNote->getLogo() }}" alt="logo" height="100">
@endif

<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" style="width: 70%;">
            <h4 class="text-uppercase">
                <strong>{{ $deliveryNote->name }}</strong>
            </h4>
        </td>
        <td class="border-0 pl-0">
            @if($deliveryNote->status)
                <h4 class="text-uppercase cool-gray">
                    <strong>{{ $deliveryNote->status }}</strong>
                </h4>
            @endif
            <p>{{ __('delivery-notes::delivery-note.serial') }} <strong>{{ $deliveryNote->getSerialNumber() }}</strong></p>
            <p>{{ __('delivery-notes::delivery-note.date') }}: <strong>{{ $deliveryNote->getDate() }}</strong></p>
            <p>{{ __('delivery-notes::delivery-note.invoice_number') }}: <strong>{{ $deliveryNote->getInvoiceNumber() }}</strong></p>
        </td>
    </tr>
    </tbody>
</table>

{{-- Seller - Buyer --}}
<table class="table">
    <thead>
    <tr>
        <th class="border-0 pl-0 party-header" style="width: 48.5%">
            {{ __('delivery-notes::delivery-note.seller') }}
        </th>
        <th class="border-0" style="width: 3%;"></th>
        <th class="border-0 pl-0 party-header">
            {{ __('delivery-notes::delivery-note.buyer') }}
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="px-0">
            @if($deliveryNote->seller->name)
                <p class="seller-name">
                    <strong>{{ $deliveryNote->seller->name }}</strong>
                </p>
            @endif

            @if($deliveryNote->seller->address)
                <p class="seller-address">
                    {{ __('delivery-notes::delivery-note.address') }}: {{ $deliveryNote->seller->address }}
                </p>
            @endif

            @if($deliveryNote->seller->code)
                <p class="seller-code">
                    {{ __('delivery-notes::delivery-note.code') }}: {{ $deliveryNote->seller->code }}
                </p>
            @endif

            @if($deliveryNote->seller->vat)
                <p class="seller-vat">
                    {{ __('delivery-notes::delivery-note.vat') }}: {{ $deliveryNote->seller->vat }}
                </p>
            @endif

            @if($deliveryNote->seller->phone)
                <p class="seller-phone">
                    {{ __('delivery-notes::delivery-note.phone') }}: {{ $deliveryNote->seller->phone }}
                </p>
            @endif

            @foreach($deliveryNote->seller->custom_fields as $key => $value)
                <p class="seller-custom-field">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
        <td class="border-0"></td>
        <td class="px-0">
            @if($deliveryNote->buyer->name)
                <p class="buyer-name">
                    <strong>{{ $deliveryNote->buyer->name }}</strong>
                </p>
            @endif

            @if($deliveryNote->buyer->address)
                <p class="buyer-address">
                    {{ __('delivery-notes::delivery-note.address') }}: {{ $deliveryNote->buyer->address }}
                </p>
            @endif

            @if($deliveryNote->buyer->code)
                <p class="buyer-code">
                    {{ __('delivery-notes::delivery-note.code') }}: {{ $deliveryNote->buyer->code }}
                </p>
            @endif

            @if($deliveryNote->buyer->vat)
                <p class="buyer-vat">
                    {{ __('delivery-notes::delivery-note.vat') }}: {{ $deliveryNote->buyer->vat }}
                </p>
            @endif

            @if($deliveryNote->buyer->phone)
                <p class="buyer-phone">
                    {{ __('delivery-notes::delivery-note.phone') }}: {{ $deliveryNote->buyer->phone }}
                </p>
            @endif

            @foreach($deliveryNote->buyer->custom_fields as $key => $value)
                <p class="buyer-custom-field">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>

{{-- Table --}}
<table class="table table-items">
    <thead>
    <tr>
        <th scope="col" class="border-0 pl-0">{{ __('delivery-notes::delivery-note.number') }}</th>
        <th scope="col" class="border-0">{{ __('delivery-notes::delivery-note.code') }}</th>
        <th scope="col" class="border-0">{{ __('delivery-notes::delivery-note.description') }}</th>
        @if($deliveryNote->hasItemUnits)
            <th scope="col" class="text-center border-0">{{ __('delivery-notes::delivery-note.units') }}</th>
        @endif
        <th scope="col" class="text-center border-0">{{ __('delivery-notes::delivery-note.quantity') }}</th>
    </tr>
    </thead>
    <tbody>
    {{-- Items --}}
    @foreach($deliveryNote->items as $item)
        <tr>
            <td class="pl-0">
                {{ $loop->iteration }}
            </td>
            <td>{{ $item->code }}</td>
            <td>
                {{ $item->title }}

                @if($item->description)
                    <p class="cool-gray">{{ $item->description }}</p>
                @endif
            </td>
            @if($deliveryNote->hasItemUnits)
                <td class="text-center">{{ $item->units }}</td>
            @endif
            <td class="text-center">{{ $item->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@if($deliveryNote->notes)
    <p>
        {{ trans('delivery-notes::delivery-note.notes') }}: {!! $deliveryNote->notes !!}
    </p>
@endif
<script type="text/php">
    if (isset($pdf) && $PAGE_COUNT > 1) {
        $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width);
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
</body>
</html>
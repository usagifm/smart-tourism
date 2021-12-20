<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4,
        .h4 {
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
            font-family: "DejaVu Sans";
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 11px;
            font-weight: 600;
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
    @if ($invoice->logo)
        <img src="{{ $invoice->items[0]->getLogoItera() }}" height="50" alt="">
        <img src="{{ $invoice->items[0]->getLogoMenujuTubaba() }}" height="50" style="margin-left: 15px" alt="">
        <img src="{{ $invoice->getLogo() }}" alt="logo" height="50" style="margin-left: 15px">
        <img src="{{ $invoice->items[0]->getLogoDishub() }}" height="50" alt="" style="margin-left: 15px">
        <img src="{{ $invoice->items[0]->getLogoDikominfoTubaba() }}" height="50" alt="" style="margin-left: 15px">
    @endif

    <table class="table mt-5">
        <tbody>
            <tr>
                <td class="border-0 pl-0" width="70%">
                    <h4 class="text-uppercase">
                        <strong>{{ $invoice->name }}</strong>
                    </h4>
                </td>
                <td class="border-0 pl-0">
                    @if ($invoice->status)
                        <h4 class="text-uppercase cool-gray">
                            <strong>{{ $invoice->status }}</strong>
                        </h4>
                    @endif
                    {{-- <p>Serial Number: <strong>{{ $invoice->getSerialNumber() }}</strong></p> --}}
                    <p>Tanggal: <strong>{{ $invoice->getDate() }}</strong></p>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Seller - Buyer --}}
    <table class="table">
        <thead>
            <tr>
                <th class="border-0 pl-0 party-header" width="48.5%">
                    {{ __('Smart Tourism Tubaba') }}
                </th>
                <th class="border-0" width="3%"></th>
                <th class="border-0 pl-0 party-header">
                    {{ $invoice->buyer->name }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-0">
                    @if ($invoice->seller->name)
                        <p class="seller-name">
                            <strong>Smart Tourism Tubaba</strong>
                        </p>
                    @endif

                    <p class="seller-address">
                        {{ __('Area') }}: {{ $invoice->items[0]->rentArea }}
                    </p>

                    @if ($invoice->seller->code)
                        <p class="seller-code">
                            {{ __('Tipe Kendaraan') }}: {{ $invoice->items[0]->vehicleType }}
                        </p>
                    @endif

                    {{-- @if ($invoice->seller->vat)
                        <p class="seller-vat">
                            {{ __('invoices::invoice.vat') }}: {{ $invoice->seller->vat }}
                        </p>
                    @endif

                    @if ($invoice->seller->phone)
                        <p class="seller-phone">
                            {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                        </p>
                    @endif

                    @foreach ($invoice->seller->custom_fields as $key => $value)
                        <p class="seller-custom-field">
                            {{ ucfirst($key) }}: {{ $value }}
                        </p>
                    @endforeach --}}
                </td>
                <td class="border-0"></td>
                <td class="px-0">
                    @if ($invoice->buyer->name)
                        <p class="buyer-name">
                            <strong>{{ $invoice->buyer->name }}</strong>
                        </p>
                    @endif

                    @if ($invoice->buyer->address)
                        <p class="buyer-address">
                            {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                        </p>
                    @endif

                    @if ($invoice->buyer->code)
                        <p class="buyer-code">
                            {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}
                        </p>
                    @endif

                    @if ($invoice->buyer->vat)
                        <p class="buyer-vat">
                            {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                        </p>
                    @endif

                    @if ($invoice->buyer->phone)
                        <p class="buyer-phone">
                            {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                        </p>
                    @endif

                    @foreach ($invoice->buyer->custom_fields as $key => $value)
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
                <th scope="col" class="border-0 pl-0">Kendaraan</th>
                <th scope="col" class="pl-0 border-0">Biaya</th>
                <th scope="col" class="pl-0 border-0">Lama Waktu</th>
                <th scope="col" class="text-right border-0 pr-0">Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- Items --}}
            @foreach ($invoice->items as $item)
                <tr>
                    <td class="pl-0">
                        {{ $item->title }}
                    </td>
                    <td class="pl-0">Rp. {{ number_format($item->quantity, 2) }} / 30 Menit</td>
                    <td class="text-right">{{ $item->total_time }} menit</td>
                    <td class="text-right pr-0">
                        Rp. {{ number_format($item->price_per_unit, 2) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('Biaya Total') }}</td>
                <td class="text-right pr-0 total-amount">
                    Rp. {{ number_format($item->price_per_unit, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    @if ($invoice->notes)
        <p>
            {{ trans('invoices::invoice.notes') }}: {!! $invoice->notes !!}
        </p>
    @endif

    {{-- <p>
            {{ trans('invoices::invoice.amount_in_words') }}: {{ $invoice->getTotalAmountInWords() }}
        </p> --}}
    {{-- <p>
        {{ trans('invoices::invoice.pay_until') }}: {{ $invoice->getPayUntilDate() }}
    </p> --}}

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

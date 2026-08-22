<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice {{ $sale->invoice_no }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: 58mm auto;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 58mm;
            background: #fff;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            line-height: 1.3;
        }

        .receipt {
            width: 58mm;
            padding: 4mm 3mm;
        }

        .center {
            text-align: center;
        }

        .business-header {
            text-align: center;
            margin-bottom: 7px;
        }

        .business-logo {
            width: 45px;
            height: 45px;
            object-fit: contain;
            margin: 0 auto 4px;
        }

        .business-name {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .business-details {
            margin-top: 3px;
            font-size: 8px;
            line-height: 1.4;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .invoice-meta {
            font-size: 8px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 5px;
            margin: 2px 0;
        }

        .meta-row span:last-child,
        .meta-row strong:last-child {
            text-align: right;
        }

        .customer {
            margin-top: 6px;
            font-size: 8px;
        }

        .customer-name {
            font-weight: 700;
        }

        .section-title {
            margin-bottom: 3px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .items th {
            padding: 3px 0;
            border-bottom: 1px solid #000;
            font-size: 7px;
            font-weight: 700;
            text-align: left;
        }

        .items td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 8px;
            border-bottom: 1px dotted #999;
        }

        .item-name {
            width: 42%;
            padding-right: 2px !important;
            word-break: break-word;
        }

        .item-qty {
            width: 13%;
            text-align: center !important;
        }

        .item-rate {
            width: 22%;
            text-align: right !important;
            padding-right: 2px !important;
        }

        .item-amount {
            width: 23%;
            text-align: right !important;
        }

        .summary {
            margin-top: 6px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 5px;
            margin: 2px 0;
            font-size: 8px;
        }

        .summary-row strong {
            font-weight: 700;
        }

        .grand-total {
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
            font-size: 12px;
            font-weight: 700;
        }

        .payment-summary {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px dashed #000;
        }

        .payment-status {
            margin-top: 5px;
            text-align: center;
            font-size: 10px;
            font-weight: 700;
        }

        .notes {
            margin-top: 7px;
            font-size: 8px;
        }

        .footer {
            margin-top: 10px;
            padding-top: 6px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 7px;
        }

        .print-button {
            position: fixed;
            top: 8px;
            right: 8px;
            padding: 6px 9px;
            border: 0;
            border-radius: 5px;
            background: #2563eb;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .print-button:hover {
            background: #1d4ed8;
        }

        @media print {
            .print-button {
                display: none;
            }

            body,
            .receipt {
                width: 58mm;
            }
        }
    </style>
</head>

<body>

    <button class="print-button" onclick="window.print()">
        Print
    </button>

    @php
        $settings = $sale->shop?->settings;

        $paidAmount = $sale->payments->sum('amount');

        $balanceDue = max(0, (float) $sale->grand_total - (float) $paidAmount);

        $saleType = $balanceDue > 0 ? 'Credit' : 'Paid';
    @endphp

    <div class="receipt">

        {{-- BUSINESS --}}
        <div class="business-header">

            @if ($settings?->logo)
                <img src="{{ asset('storage/' . $settings->logo) }}"
                    alt="{{ $settings->business_name ?? 'Business Logo' }}" class="business-logo">
            @endif

            <h1 class="business-name">
                {{ $settings?->business_name ?? ($sale->shop?->name ?? 'My Store') }}
            </h1>

            <div class="business-details">

                @if ($settings?->address)
                    {{ $settings->address }}<br>
                @endif

                @if ($settings?->phone)
                    {{ $settings->phone }}<br>
                @endif

                @if ($settings?->email)
                    {{ $settings->email }}<br>
                @endif

                @if ($settings?->gst)
                    GST: {{ $settings->gst }}<br>
                @endif

                @if ($settings?->fssai)
                    FSSAI: {{ $settings->fssai }}
                @endif

            </div>

        </div>

        <div class="divider"></div>

        {{-- INVOICE --}}
        <div class="invoice-meta">

            <div class="meta-row">
                <span>Invoice</span>
                <strong>{{ $sale->invoice_no }}</strong>
            </div>

            <div class="meta-row">
                <span>Date</span>
                <span>
                    {{ \Carbon\Carbon::parse($sale->invoice_date)->format('d M Y') }}
                </span>
            </div>

            <div class="meta-row">
                <span>Sale</span>
                <strong>{{ $saleType }}</strong>
            </div>

        </div>

        {{-- CUSTOMER --}}
        <div class="customer">

            <div class="section-title">
                Bill To
            </div>

            <div class="customer-name">
                {{ $sale->customer?->name ?? 'Walk-in Customer' }}
            </div>

            @if ($sale->customer?->phone)
                <div>
                    {{ $sale->customer->phone }}
                </div>
            @endif

        </div>

        <div class="divider"></div>

        {{-- ITEMS --}}
        <table class="items">

            <thead>
                <tr>
                    <th class="item-name">Item</th>
                    <th class="item-qty">Qty</th>
                    <th class="item-rate">Rate</th>
                    <th class="item-amount">Amt</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($sale->items as $item)
                    <tr>

                        <td class="item-name">
                            {{ $item->item_name }}
                        </td>

                        <td class="item-qty">
                            {{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}
                        </td>

                        <td class="item-rate">
                            ₹{{ number_format($item->rate, 2) }}
                        </td>

                        <td class="item-amount">
                            ₹{{ number_format($item->amount, 2) }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

        {{-- SUMMARY --}}
        <div class="summary">

            <div class="summary-row">
                <span>Subtotal</span>
                <strong>
                    ₹{{ number_format($sale->subtotal, 2) }}
                </strong>
            </div>

            @if ($sale->discount > 0)
                <div class="summary-row">
                    <span>Discount</span>
                    <strong>
                        -₹{{ number_format($sale->discount, 2) }}
                    </strong>
                </div>
            @endif

            @if ($sale->tax > 0)
                <div class="summary-row">
                    <span>Tax</span>
                    <strong>
                        ₹{{ number_format($sale->tax, 2) }}
                    </strong>
                </div>
            @endif

            <div class="summary-row grand-total">
                <span>TOTAL</span>
                <strong>
                    ₹{{ number_format($sale->grand_total, 2) }}
                </strong>
            </div>

        </div>

        {{-- PAYMENT --}}
        <div class="payment-summary">

            <div class="summary-row">
                <span>Method</span>
                <strong>
                    {{ ucfirst($sale->payment_method) }}
                </strong>
            </div>

            <div class="summary-row">
                <span>Paid</span>
                <strong>
                    ₹{{ number_format($paidAmount, 2) }}
                </strong>
            </div>

            @if ($balanceDue > 0)
                <div class="summary-row">
                    <span>Due</span>
                    <strong>
                        ₹{{ number_format($balanceDue, 2) }}
                    </strong>
                </div>
            @endif

            <div class="payment-status">
                {{ $saleType }}
            </div>

        </div>

        {{-- NOTES --}}
        @if ($sale->notes)
            <div class="notes">

                <div class="section-title">
                    Notes
                </div>

                <div>
                    {!! nl2br(e($sale->notes)) !!}
                </div>

            </div>
        @endif

        {{-- FOOTER --}}
        @if ($settings?->footer_text)
            <div class="footer">
                {!! nl2br(e($settings->footer_text)) !!}
            </div>
        @endif

    </div>

</body>

</html>

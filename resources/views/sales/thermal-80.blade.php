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
            size: 80mm auto;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 80mm;
            background: #fff;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.35;
        }

        .receipt {
            width: 80mm;
            padding: 5mm 4mm;
        }

        .center {
            text-align: center;
        }

        .business-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .business-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
            margin: 0 auto 5px;
        }

        .business-name {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .business-details {
            margin-top: 4px;
            font-size: 10px;
            line-height: 1.45;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .invoice-meta {
            font-size: 10px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 2px 0;
        }

        .meta-row span:last-child {
            text-align: right;
        }

        .customer {
            margin-top: 7px;
            font-size: 10px;
        }

        .customer-name {
            font-weight: 700;
        }

        .section-title {
            margin-bottom: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .items th {
            padding: 4px 0;
            border-bottom: 1px solid #000;
            font-size: 9px;
            font-weight: 700;
            text-align: left;
        }

        .items td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 10px;
            border-bottom: 1px dotted #999;
        }

        .item-name {
            width: 45%;
            padding-right: 3px !important;
            word-wrap: break-word;
        }

        .item-qty {
            width: 15%;
            text-align: center !important;
        }

        .item-rate {
            width: 20%;
            text-align: right !important;
            padding-right: 3px !important;
        }

        .item-amount {
            width: 20%;
            text-align: right !important;
        }

        .summary {
            margin-top: 8px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 3px 0;
            font-size: 10px;
        }

        .summary-row strong {
            font-weight: 700;
        }

        .grand-total {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid #000;
            font-size: 14px;
            font-weight: 700;
        }

        .payment-summary {
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px dashed #000;
        }

        .payment-status {
            margin-top: 6px;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
        }

        .notes {
            margin-top: 9px;
            font-size: 10px;
        }

        .footer {
            margin-top: 14px;
            padding-top: 8px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 9px;
        }

        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 8px 12px;
            border: 0;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            font-size: 12px;
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

            body {
                width: 80mm;
            }

            .receipt {
                width: 80mm;
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

        {{-- INVOICE META --}}
        <div class="invoice-meta">

            <div class="meta-row">
                <span>Invoice</span>
                <strong>{{ $sale->invoice_no }}</strong>
            </div>

            <div class="meta-row">
                <span>Date</span>
                <span>
                    {{ \Carbon\Carbon::parse($sale->invoice_date)->format('d M Y, h:i A') }}
                </span>
            </div>

            <div class="meta-row">
                <span>Sale Type</span>
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
                    <th class="item-amount">Amount</th>
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
                <span>Payment Method</span>
                <strong>
                    {{ ucfirst($sale->payment_method) }}
                </strong>
            </div>

            <div class="summary-row">
                <span>Amount Paid</span>
                <strong>
                    ₹{{ number_format($paidAmount, 2) }}
                </strong>
            </div>

            @if ($balanceDue > 0)
                <div class="summary-row">
                    <span>Balance Due</span>
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

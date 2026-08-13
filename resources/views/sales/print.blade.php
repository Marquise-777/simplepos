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

        body {
            margin: 0;
            background: #f1f5f9;
            color: #0f172a;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .invoice-wrapper {
            width: 210mm;
            min-height: 297mm;
            margin: 30px auto;
            padding: 18mm;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #0f172a;
        }

        .business-name {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .business-details {
            margin-top: 8px;
            color: #64748b;
            line-height: 1.6;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 30px;
            letter-spacing: 1px;
        }

        .invoice-meta {
            margin-top: 10px;
            color: #64748b;
            line-height: 1.7;
        }

        .invoice-meta strong {
            color: #0f172a;
        }

        .customer-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
        }

        .section-label {
            margin-bottom: 7px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
        }

        .customer-name {
            font-size: 16px;
            font-weight: 700;
        }

        .customer-details {
            margin-top: 5px;
            color: #64748b;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead {
            background: #f8fafc;
        }

        .items-table th {
            padding: 12px;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .items-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .summary-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .summary {
            width: 320px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #475569;
        }

        .summary-row.total {
            margin-top: 8px;
            padding-top: 15px;
            border-top: 2px solid #0f172a;
            color: #0f172a;
            font-size: 18px;
            font-weight: 700;
        }

        .payment-box {
            margin-top: 30px;
            padding: 15px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .payment-box strong {
            text-transform: capitalize;
        }

        .notes {
            margin-top: 30px;
        }

        .notes-text {
            color: #64748b;
            line-height: 1.6;
            white-space: pre-line;
        }

        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 11px 18px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .print-button:hover {
            background: #1d4ed8;
        }

        @media print {

            @page {
                size: A4;
                margin: 0;
            }

            body {
                background: #ffffff;
            }

            .invoice-wrapper {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 18mm;
                box-shadow: none;
            }

            .print-button {
                display: none;
            }
        }

        @media screen and (max-width: 700px) {

            body {
                background: #f1f5f9;
            }

            .invoice-wrapper {
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 20px;
                box-shadow: none;
            }

            .invoice-header {
                flex-direction: column;
            }

            .invoice-title {
                text-align: left;
            }

            .customer-section {
                grid-template-columns: 1fr;
            }

            .summary-wrapper {
                justify-content: stretch;
            }

            .summary {
                width: 100%;
            }

            .print-button {
                position: static;
                display: block;
                width: calc(100% - 40px);
                margin: 20px;
            }
        }
    </style>
</head>

<body>

    <button class="print-button" onclick="window.print()">
        Print Invoice
    </button>

    <div class="invoice-wrapper">

        {{-- HEADER --}}
        <div class="invoice-header">

            <div>

                <h1 class="business-name">
                    {{ auth()->user()->shop->settings->business_name ?? (auth()->user()->shop->name ?? 'My Store') }}
                </h1>

                <div class="business-details">

                    @if ($sale->shop?->address)
                        {{ $sale->shop->address }}<br>
                    @endif

                    @if ($sale->shop?->phone)
                        Phone: {{ $sale->shop->phone }}<br>
                    @endif

                    @if ($sale->shop?->email)
                        Email: {{ $sale->shop->email }}
                    @endif

                </div>

            </div>

            <div class="invoice-title">

                <h2>INVOICE</h2>

                <div class="invoice-meta">

                    <div>
                        <strong>Invoice:</strong>
                        {{ $sale->invoice_no }}
                    </div>

                    <div>
                        <strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($sale->invoice_date)->format('d M Y') }}
                    </div>

                    <div>
                        <strong>Status:</strong>
                        {{ ucfirst($sale->status) }}
                    </div>

                </div>

            </div>

        </div>


        {{-- CUSTOMER --}}
        <div class="customer-section">

            <div>

                <div class="section-label">
                    Bill To
                </div>

                <div class="customer-name">
                    {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                </div>

                @if ($sale->customer)

                    <div class="customer-details">

                        @if ($sale->customer->phone)
                            {{ $sale->customer->phone }}<br>
                        @endif

                        @if ($sale->customer->email)
                            {{ $sale->customer->email }}<br>
                        @endif

                        @if ($sale->customer->address)
                            {{ $sale->customer->address }}
                        @endif

                    </div>

                @endif

            </div>


            <div>

                <div class="section-label">
                    Payment Method
                </div>

                <div class="customer-name">
                    {{ ucfirst($sale->payment_method) }}
                </div>

            </div>

        </div>


        {{-- ITEMS --}}
        <table class="items-table">

            <thead>

                <tr>

                    <th style="width: 8%;">
                        #
                    </th>

                    <th>
                        Item
                    </th>

                    <th class="text-center" style="width: 15%;">
                        Qty
                    </th>

                    <th class="text-right" style="width: 18%;">
                        Rate
                    </th>

                    <th class="text-right" style="width: 20%;">
                        Amount
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach ($sale->items as $index => $item)
                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->item_name }}
                        </td>

                        <td class="text-center">
                            {{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($item->rate, 2) }}
                        </td>

                        <td class="text-right">
                            ₹{{ number_format($item->amount, 2) }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>


        {{-- SUMMARY --}}
        <div class="summary-wrapper">

            <div class="summary">

                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        ₹{{ number_format($sale->subtotal, 2) }}
                    </strong>

                </div>


                @if ($sale->discount > 0)
                    <div class="summary-row">

                        <span>
                            Discount
                        </span>

                        <strong>
                            - ₹{{ number_format($sale->discount, 2) }}
                        </strong>

                    </div>
                @endif


                @if ($sale->tax > 0)
                    <div class="summary-row">

                        <span>
                            Tax
                        </span>

                        <strong>
                            ₹{{ number_format($sale->tax, 2) }}
                        </strong>

                    </div>
                @endif


                <div class="summary-row total">

                    <span>
                        Grand Total
                    </span>

                    <span>
                        ₹{{ number_format($sale->grand_total, 2) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- PAYMENT --}}
        <div class="payment-box">

            Payment received via
            <strong>
                {{ $sale->payment_method }}
            </strong>

        </div>


        {{-- NOTES --}}
        @if ($sale->notes)
            <div class="notes">

                <div class="section-label">
                    Notes
                </div>

                <div class="notes-text">
                    {{ $sale->notes }}
                </div>

            </div>
        @endif


        {{-- FOOTER --}}
        @if ($sale->shop->settings?->footer_text)
            <div class="footer">
                {{ $sale->shop->settings->footer_text }}
            </div>
        @endif

    </div>

</body>

</html>

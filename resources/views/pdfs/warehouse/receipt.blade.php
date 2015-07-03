<?php $grossWeight = $warehouse->calculateGrossWeight(); ?>
<?php $cubicFeet = $warehouse->calculateCubicFeet(); ?>
<?php $chargeWeight = $warehouse->calculateChargeWeight(); ?>
<?php $packages = $warehouse->packages; ?>
<?php $totalPackages = count($packages); ?>
<?php $consignee = $warehouse->consignee; ?>
<?php $company = Auth::user()->site->company; ?>
<style>
    .receipt-number {
        font-size: 20px;
    }
</style>

<table border="0">
    <tr>
        <td width="60%">
            {!! ($url = $company->getLogoUrl()) ? '<img src="' . $url . '"><br>' : '' !!}

            {{ strtoupper($company->name) }}<br>
            {{ strtoupper($company->address1) }}<br>
            {!! ($company->address2) ? strtoupper($company->address2) . '<br>' : '' !!}
            {{ strtoupper($company->city . ', ' . $company->state . ' ' . $company->postal_code) }}<br>
            {{ ($company->country_id) ? strtoupper($company->country->name) : '' }}<br>
            TEL: {{ $company->phone }}<br>
            EMAIL: {{ $company->email }}<br><br>

            RECEIVED FOR:<br><br>
            {{ strtoupper($consignee->getFullName()) }}<br>
            {{ strtoupper($consignee->address1) }}<br>
            {!! ($company->consignee) ? strtoupper($consignee->address2) . '<br>' : '' !!}
            {{ strtoupper($consignee->city . ', ' . $consignee->state . ' ' . $consignee->postal_code) }}<br>
            {{ ($consignee->country_id) ? strtoupper($consignee->country->name) : '' }}<br>
        </td>

        <td width="40%">
            <br><br><br><br><br><img src="data:image/png;base64,{{ $barcodeBase64 }}">
            <h1>WAREHOUSE RECEIPT</h1>
            <table border="1">
                <tr>
                    <td><small>ACCOUNT</small><br></td>
                    <td><small>NUMBER</small><br><span class="receipt-number">{{ $warehouse->id }}</span></td>
                </tr>
                <tr>
                    <td><small>DATE</small><br>{{ date('n/d/Y', strtotime($warehouse->arrived_at)) }}</td>
                    <td><small>PIECES</small><br>{{ $totalPackages }}</td>
                </tr>
                <tr>
                    <td><small>GROSS WEIGHT</small><br>{{ $grossWeight }} LBS</td>
                    <td><small>CUBIC</small><br>{{ $cubicFeet }} CF</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table border="1">
    <tr>
        <td><small>RECEIVED FROM</small><br>{{ strtoupper($warehouse->shipper->business_name) }}</td>
        <td><small>DELIVERED BY</small><br>{{ $warehouse->courier->name }}</td>
    </tr>
</table>
<table border="1">
    <tr>
        <td><small>DESCRIPTION</small><br>{{ strtoupper($warehouse->description) }}</td>
    </tr>
</table>

<br>
<br>

<table id="packages" celspacing="0" celpadding="0">
    <tr>
        <td width="70%"><table border="1">
                <tr>
                    <td>TYPE</td>
                    <td>LENGTH</td>
                    <td>WIDTH</td>
                    <td>HEIGHT</td>
                    <td>WEIGHT</td>
                    <td>TRACKING</td>
                </tr>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ ($package->type_id) ? strtoupper($package->type->name) : '' }}</td>
                        <td>{{ $package->length }}</td>
                        <td>{{ $package->width }}</td>
                        <td>{{ $package->height }}</td>
                        <td>{{ $package->weight }} LBS</td>
                        <td>{{ $package->tracking_number }}</td>
                    </tr>
                @endforeach
                @if ($totalPackages < 21)
                    @for ($i = 0; $i < 21-$totalPackages; $i++)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                @endif
            </table>
        </td>
        <td width="30%">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table id="metrics" border="1">
                <tr><td colspan="2"><small>PIECES</small><br><span style="font-size:16px;">{{ $totalPackages }}</span></td></tr>
                <tr>
                    <td><small>POUNDS</small><br><span style="font-size:16px;">{{ $grossWeight }}</span></td>
                    <td><small>KILOS</small><br><span style="font-size:16px;">{{ \App\Helpers\Math::poundsToKilos($grossWeight, 0) }}</span></td>
                </tr>
                <tr>
                    <td><small>CUBIC FEET</small><br><span style="font-size:16px;">{{ $cubicFeet }}</span></td>
                    <td><small>CUBIC METERS</small><br><span style="font-size:16px;">{{ $warehouse->calculateCubicMeter() }}</span></td>
                </tr>
                <tr>
                    <td><small>CHARGE WEIGHT</small><br><span style="font-size:16px;">{{ round($chargeWeight) }} <small>Lb</small></span></td>
                    <td><small>CHARGE WEIGHT</small><br><span style="font-size:16px;">{{ \App\Helpers\Math::poundsToKilos($chargeWeight, 0) }} <small>Kg</small></span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br>

<table border="1">
    <tr>
        <td>
            <small>REMARKS</small>
            <br>
            <br>
            <br>
            <br>
            <small>CREATED BY: {{ Auth::user()->getFullName() }} using {{ env('APP_NAME') }}</small>
        </td>
    </tr>
</table>

<p>I consent for ALL cargo from this date forward, without exception tender, to inspection and/or screening by {{ strtoupper($company->name) }}, and/or other government authority.</p>


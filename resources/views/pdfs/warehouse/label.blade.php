<?php $client = $warehouse->client; ?>
<?php $company = $warehouse->company; ?>
<?php $grossWeight = $warehouse->calculateGrossWeight(); ?>
<?php $shipper = $warehouse->shipper; ?>

<table border="0" cellpadding="2">
    <tr>
        {!! $company->has_logo ? '<td width="23%"><img src="' . $company->present()->logoUrl('sm') . '"></td>' : '' !!}
        <td width="45%">
<b>{{ strtoupper($company->name) }}</b><br>
{!! strtoupper($company->present()->address()) !!}<br>
TEL: {{ $company->phone }}<br>
EMAIL: {{ $company->email }}
        </td>
        <td width="32%" align="right">
            <h3>Sticker # %%STICKER_NUMBER%% / {{ $totalPackages }}</h3>
        </td>
    </tr>
</table>

<br>

<table border="1"></table>

<br>
<br>

<table>
    <tr>
        <td width="20%">FROM:</td>
        <td width="80%">
<b>{{ strtoupper($warehouse->present()->shipper()) }}</b><br>
{!! strtoupper($shipper->present()->address()) !!}<br>
        </td>
    </tr>
    <tr>
        <td width="20%">TO:</td>
        <td width="80%">
<b>{{ strtoupper($client->name) }}</b><br>
{!! strtoupper($client->present()->address()) !!}<br>
        </td>
    </tr>
</table>

<br>

<table border="1"></table>

<br>

<div style="text-align:right">
    DATE: <b>{{ strtoupper(date('j-M-y', strtotime($warehouse->arrived_at))) }}</b>
</div>

<br>

<table border="1"></table>

<br>
<br>

<table>
    <tr>
        <td><h1>{{ $warehouse->id }}</h1></td>
        <td><img width="200" height="50" src="data:image/png;base64,{{ $barcodeBase64 }}"></td>
        <td></td>
    </tr>
    <tr>
        <td>PIECES: <strong>{{ $totalPackages }}</strong></td>
        <td>WEIGHT <strong>{{ $grossWeight }} Lbs</strong></td>
        <td>WEIGHT <strong>{{ \App\Helpers\Math::lbToKg($grossWeight) }} Kg</strong></td>
    </tr>
</table>

<br>
<br>
<br>

DESCRIPTION

<br>
<br>
<br>

TRACKING

<br>
<br>

<table border="1" cellpadding="1">
    <tr>
        <td height="40">
<?php
    $trackingNumbers = [];
    foreach ($packages as $package)  {
        if ( ! empty($package->tracking_number)) {
            $trackingNumbers[] = $package->tracking_number;
        }
    }
    echo implode(', ', $trackingNumbers);
?>
        </td>
    </tr>
</table>


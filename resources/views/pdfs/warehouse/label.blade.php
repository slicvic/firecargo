<?php $consignee = $warehouse->consignee; ?>
<?php $company = $warehouse->company; ?>
<?php $grossWeight = $warehouse->calculateGrossWeight(); ?>
<?php $shipper = $warehouse->shipper; ?>

<table border="0">
    <tr>
        <td width="50"><img width="50" height="50" src="/assets/img/avatar.png"></td>
        <td>
{{ strtoupper($company->name) }}<br>
{!! strtoupper($company->present()->address()) !!}<br>
TEL: {{ $company->phone }}<br>
EMAIL: {{ $company->email }}
        </td>
        <td><br><br><h2>Sticker # %%STICKER_NUMBER%% / {{ $totalPackages }}</h2></td>
    </tr>
</table>

<br>
<br>

<table border="1"></table>

<br>
<br>

<table>
    <tr>
        <td width="10%">FROM:</td>
        <td>
<b>{{ strtoupper($warehouse->present()->shipper()) }}</b><br>
{!! strtoupper($shipper->present()->address()) !!}<br>
<br>
        </td>
    </tr>
    <tr>
        <td width="10%">TO:</td>
        <td>
<b>{{ strtoupper($consignee->present()->fullname()) }}</b><br>
{!! strtoupper($consignee->address->asString()) !!}<br>
        </td>
    </tr>
</table>

<br>
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
        <td><img width="200" height="50" src="/assets/admin/img/avatar.png"></td>
        <td></td>
    </tr>
    <tr>
        <td>PIECES: {{ $totalPackages }}</td>
        <td>WEIGHT {{ $grossWeight }} Lbs</td>
        <td>WEIGHT {{ \App\Helpers\Math::poundsToKilos($grossWeight) }} Kg</td>
    </tr>
</table>

<br>
<br>

DESCRIPTION<br>
<table border="1">
    <tr>
        <td style="font-size:8px;"><br><br>&nbsp;{{ strtoupper($warehouse->notes) }}<br></td>
    </tr>
</table>

<br>
<br>

TRACKING

<br>

<table border="1">
    <tr>
        <td style="font-size:8px;">
            <br>
            <br>
            <?php
                $trackingNumbers = [];
                foreach ($packages as $package) $trackingNumbers[] = $package->tracking_number;
                echo implode(', ', $trackingNumbers);
            ?>
            <br>
        </td>
    </tr>
</table>

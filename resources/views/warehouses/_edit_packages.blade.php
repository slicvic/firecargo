<div class="ibox">
    <div class="ibox-content">
        <h2>Pieces</h2>
        <h4  class="">Add pieces to warehouse.</h4>
        <div class="clear hr-line-dashed"></div>

        @include('warehouses._metric_system_alert')

        <div class="row">
            <div class="col-md-5">
                <div class="input-group">
                    <input type="text" id="add-package-tracking" class="form-control" placeholder="Tracking # (optional)">
                    <span class="input-group-btn">
                        <button type="button" id="add-package-btn" class="btn btn-success"><i class="fa fa-plus"></i> Add New</button>
                    </span>
                </div>
            </div>
        </div>

        <br><br>

        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <span id="total-packages" class="btn btn-default m-r-sm">0</span>
                        Pieces
                    </td>
                    <td>
                        <span id="gross-weight" class="btn btn-default m-r-sm">0</span>
                        Gross Weight
                    </td>
                    <td>
                        <span id="volume-weight" class="btn btn-default m-r-sm">0</span>
                        Volume Weight
                    </td>
                    <td>
                        <span id="charge-weight" class="btn btn-default m-r-sm">0</span>
                        Charge Weight
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="packages-container">
            @include('warehouses._edit_package', ['package' => new \App\Models\Package()])

            @foreach ($warehouse->packages as $package)
                @include('warehouses._edit_package', ['package' => $package])
            @endforeach
        </div>

    </div>
</div>

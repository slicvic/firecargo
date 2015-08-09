<div id="shipments-table" class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                @if ($isAdminUser)
                    <th>{!! Html::linkToSort('/accounts', 'Company', 'company_id', $params['sort'], $params['order']) !!}</th>
                @endif
                <th>{!! Html::linkToSort('/accounts', 'ID', 'id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/accounts', 'Name', 'name', $params['sort'], $params['order']) !!}</th>
                <th>Type</th>
                <th>{!! Html::linkToSort('/accounts', 'Email', 'email', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/accounts', 'Phone', 'phone', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/accounts', 'Mobile', 'mobile_phone', $params['sort'], $params['order']) !!}</th>
                <th>Address</th>
                <th>{!! Html::linkToSort('/accounts', 'Registered?', 'user_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/accounts', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/accounts', 'Updated', 'updated_at', $params['sort'], $params['order']) !!}</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    @if ($isAdminUser)
                        <td>{{ $account->company->name }}</td>
                    @endif
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{!! $account->present()->tags() !!}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->phone }}</td>
                    <td>{{ $account->mobile_phone }}</td>
                    <td>{!! $account->present()->address('shipping') !!}</td>
                    <td>{!! $account->user_id ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}</td>
                    <td>{{ $account->present()->createdAt() }}</td>
                    <td>{{ $account->present()->updatedAt() }}</td>
                    <td>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-sm btn-white dropdown-toggle">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="/account/{{ $account->id }}/edit">Edit</a></li>
                                <li class="divider"></li>
                                <li><a href="/account/{{ $account->id }}/delete" class="delete-record-btn">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

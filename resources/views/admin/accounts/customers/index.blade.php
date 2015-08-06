@extends('admin.accounts.layout')

@section('accounts_title', 'Customers')

@section('thead')
    @if ($isAdminUser)
        <th>Company</th>
    @endif
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Address</th>
    <th>Registered?</th>
    <th>Created</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($accounts as $account)
        <tr>
            @if ($isAdminUser)
                <td>{{ $account->company->name }}</td>
            @endif
            <td>{{ $account->id }}</td>
            <td>{{ $account->name }}</td>
            <td>{{ $account->email }}</td>
            <td>{{ $account->phone }}</td>
            <td>{{ $account->mobile_phone }}</td>
            <td>{!! $account->present()->address() !!}</td>
            <td>{!! $account->user_id ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}</td>
            <td>{{ $account->present()->createdAt() }}</td>
            <td><a href="/accounts/customer/{{ $account->id }}/edit" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop

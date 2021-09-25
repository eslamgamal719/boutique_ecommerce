@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Customer Addresses</h6>
            <div class="ml-auto">

                @can('create_customer_address')
                <a href="{{ route('admin.customer_addresses.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new customer address</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.customer_addresses.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Title</th>
                        <th>Shipping info</th>
                        <th>Location</th>
                        <th>Address</th>
                        <th>Zip code</th>
                        <th>PO Box</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customer_addresses as $customer_address)
                    <tr>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer_address->user_id) }}">{{ $customer_address->user->full_name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.customer_addresses.show', $customer_address->id) }}">{{ $customer_address->title }}</a>
                            <p class="text-gray-400">{{ $customer_address->defaultAddress() }}</p>
                        </td>
                        <td>
                            {{ $customer_address->first_name . ' ' . $customer_address->last_name }}
                            <p class="text-gray-400">{{ $customer_address->email }}<br>{{ $customer_address->mobile }}</P>
                        </td>
                        <td>{{ $customer_address->country->name . ' - ' . $customer_address->state->name . ' - ' . $customer_address->city->name }}</td>
                        <td>{{ $customer_address->address }}</td>
                        <td>{{ $customer_address->zip_code }}</td>
                        <td>{{ $customer_address->po_box }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.customer_addresses.edit', $customer_address->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $customer_address->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.customer_addresses.destroy', $customer_address->id) }}" method="post" id="form-delete-{{ $customer_address->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No customer addresses found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <div class="float-right">
                                {!! $customer_addresses->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
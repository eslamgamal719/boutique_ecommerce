@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
            <div class="ml-auto">

                @can('create_customer')
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new customer</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.customers.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email & Mobile</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>
                            @if($customer->user_image != '')
                                <img src="{{ asset('assets/customers/' . $customer->user_image) }}" alt="{{ $customer->full_name }}" width="60" height="60">
                            @else
                                <img src="{{ asset('assets/customers/default.png') }}" width="60" height="60">
                            @endif
                        </td>
                        <td>
                            {{ $customer->full_name }}<br>
                            <small>{{ $customer->username }}</small>
                        </td>
                        <td>
                            {{ $customer->email }}<br>
                            {{ $customer->mobile }}
                        </td>
                        <td>{{ $customer->status() }}</td>
                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $customer->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="post" id="form-delete-{{ $customer->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $customers->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
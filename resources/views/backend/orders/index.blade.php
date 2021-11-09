@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
        </div>

        @include('backend.orders.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>User</th>
                        <th>Payment method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created date</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->ref_id }}</td>
                        <td>{{ $order->user->full_name }}</td>
                        <td>{{ $order->payment_method->name }}</td>
                        <td>{{ $order->currency . $order->total }}</td>
                        <td>{!! $order->statusWithLabel() !!}</td>
                        <td>{{ $order->created_at->format('Y-m-d h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('display_order')
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                @endcan
                                @can('delete_order')
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $order->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                                @endcan
                            </div>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="post" id="form-delete-{{ $order->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="float-right">
                                {!! $orders->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Shipping Companies</h6>
            <div class="ml-auto">

                @can('create_shipping_company')
                <a href="{{ route('admin.shipping_companies.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new company</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.shipping_companies.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Fast</th>
                        <th>Cost</th>
                        <th>Countires count</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shipping_companies as $shipping_company)
                    <tr>
                        <td>{{ $shipping_company->name }}</td>
                        <td>{{ $shipping_company->code }}</td>
                        <td>{{ $shipping_company->description }}</td>
                        <td>{{ $shipping_company->fast() }}</td>
                        <td>{{ $shipping_company->cost }}</td>
                        <td>{{ $shipping_company->countries_count }}</td>
                        <td>{{ $shipping_company->status() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.shipping_companies.edit', $shipping_company->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $shipping_company->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.shipping_companies.destroy', $shipping_company->id) }}" method="post" id="form-delete-{{ $shipping_company->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No shipping companies found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <div class="float-right">
                                {!! $shipping_companies->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
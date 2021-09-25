@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Cities</h6>
            <div class="ml-auto">

                @can('create_city')
                <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new city</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.cities.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>State</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cities as $city)
                    <tr>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->state->name }}</td>
                        <td>{{ $city->status() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('update_city')
                                <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete_city')
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $city->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                                @endcan
                            </div>
                            <form action="{{ route('admin.cities.destroy', $city->id) }}" method="post" id="form-delete-{{ $city->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No cities found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="float-right">
                                {!! $cities->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
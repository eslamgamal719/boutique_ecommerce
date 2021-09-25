@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Countries</h6>
            <div class="ml-auto">

                @can('create_country')
                <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new country</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.countries.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>States count</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($countries as $country)
                    <tr>
                        <td>{{ $country->name }}</td>
                        <td>{{ $country->states_count }}</td>
                        <td>{{ $country->status() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('update_country')
                                <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete_country')
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $country->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                                @endcan
                            </div>
                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="post" id="form-delete-{{ $country->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No countries found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="float-right">
                                {!! $countries->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">States</h6>
            <div class="ml-auto">

                @can('create_state')
                <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new state</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.states.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Cities count</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($states as $state)
                    <tr>
                        <td>{{ $state->name }}</td>
                        <td>{{ $state->cities_count }}</td>
                        <td>{{ $state->country->name }}</td>
                        <td>{{ $state->status() }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @can('update_city')
                                <a href="{{ route('admin.states.edit', $state->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete_city')
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $state->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                                @endcan
                            </div>
                            <form action="{{ route('admin.states.destroy', $state->id) }}" method="post" id="form-delete-{{ $state->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No states found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="float-right">
                                {!! $states->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Supervisors</h6>
            <div class="ml-auto">

                @can('create_supervisor')
                <a href="{{ route('admin.supervisors.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new supervisor</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.supervisors.filters.filter')

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
                    @forelse ($supervisors as $supervisor)
                    <tr>
                        <td>
                            @if($supervisor->user_image != '')
                                <img src="{{ asset('assets/supervisors/' . $supervisor->user_image) }}" alt="{{ $supervisor->full_name }}" width="60" height="60">
                            @else
                                <img src="{{ asset('assets/supervisors/avatar.png') }}" width="60" height="60">
                            @endif
                        </td>
                        <td>
                            {{ $supervisor->full_name }}<br>
                            <small>{{ $supervisor->username }}</small>
                        </td>
                        <td>
                            {{ $supervisor->email }}<br>
                            {{ $supervisor->mobile }}
                        </td>
                        <td>{{ $supervisor->status() }}</td>
                        <td>{{ $supervisor->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $supervisor->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}" method="post" id="form-delete-{{ $supervisor->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No supervisors found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $supervisors->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
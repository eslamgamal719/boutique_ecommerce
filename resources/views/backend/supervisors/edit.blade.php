@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit supervisor ({{ $supervisor->full_name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.supervisors.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>  
                    <span class="text">Supervisors</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.supervisors.update', $supervisor->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $supervisor->id }}">

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $supervisor->first_name) }}" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $supervisor->last_name) }}" class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="{{ old('username', $supervisor->username) }}" class="form-control">
                            @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email', $supervisor->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $supervisor->mobile) }}" class="form-control">
                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $supervisor->status) == '1' ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status', $supervisor->status) == '0' ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="role_name">Permission</label>
                            <select name="role_name" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role_name', $supervisor->role_name) == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="user_image">User Image</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="user_image" id="supervisor-image" class="file-input-overview">
                            <span class="form-text text-muted">Image width should be 300px * 300px</span>
                            @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>  
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update Supervisor</button>
                </div>

            </form>
        </div>
</div>


@push('scripts')
    <script>
        $(function() {
            $('#supervisor-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,

                initialPreview: [
                    @if ($supervisor->user_image != '')
                        "{{ asset('assets/supervisors/' . $supervisor->user_image) }}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($supervisor->user_image != '')
                    {
                        caption: "{{ $supervisor->user_image }}",
                        size: "1111",
                        width: "120px",
                        url: "{{ route('admin.supervisors.remove_image', ['supervisor_id' => $supervisor->id, '_token' => csrf_token()]) }}",
                        key: {{ $supervisor->id }}

                    }
                    @endif
                ]
            });
        });
    </script>
@endpush
@endsection
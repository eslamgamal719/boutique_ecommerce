@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit tag ( {{ $tag->name }} )</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.tags.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        
                    </span>
                    <span class="text">Tag</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                
                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="0" {{ old('status', $tag->status) == 0 ? 'selected' : ''}}>Inactive</option>
                                <option value="1" {{ old('status', $tag->status) == 1 ? 'selected' : ''}}>Active</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update Tag</button>
                </div>

            </form>
        </div>
</div>

@endsection
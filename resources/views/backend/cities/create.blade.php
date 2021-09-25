@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create city</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.cities.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Cities</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.cities.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>
                
                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == '1' ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="state_id">State</label>
                            <select name="state_id" class="form-control">
                                <option value="">---</option>
                                @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : ''}}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Add state</button>
                </div>

            </form>
        </div>
</div>

@endsection
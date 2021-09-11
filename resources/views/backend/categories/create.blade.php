@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create category</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Category</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
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
                            <label for="parent_id">Parent</label>
                            <select name="parent_id" class="form-control">
                                <option value="">---</option>
                                @forelse ($main_categories as $main_category)
                                    <option value="{{ $main_category->id }}" {{ old('parent_id') == $main_category->id ? 'selected' : ''}}>{{ $main_category->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('parent_id')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="0" {{ old('status') == 0 ? 'selected' : ''}}>Inactive</option>
                                <option value="1" {{ old('status') == 1 ? 'selected' : ''}}>Active</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="cover">Cover</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="cover" id="category-image" class="file-input-overview">
                            <span class="form-text text-muted">Image width should be 500px * 500px</span>
                            @error('cover')<span class="text-danger">{{ $messages }}</span>@enderror
                        </div>
                    </div>  
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>

            </form>
        </div>
</div>


@push('scripts')
    <script>
        $(function() {
            $('#category-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>
@endpush
@endsection
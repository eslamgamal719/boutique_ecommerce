@extends('layouts.backend.app')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endpush

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit product ({{ $product->name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Products</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                

                    <div class="col-3">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option>---</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('category')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="description">Description</label>
                        <textarea name="description" rows="3" class="form-control summernote">
                            {!! old('description', $product->description) !!}
                        </textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-4">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}">
                        @error('quantity')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="featured">Featured</label>
                            <select name="featured" class="form-control">
                                <option value="1" {{ old('featured', $product->featured) == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{ old('featured', $product->featured) == 0 ? 'selected' : ''}}>No</option>
                            </select>
                            @error('featured')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="tags">Tags</label>
                        <select name="tags[]" class="form-control select2" multiple>
                            @forelse ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="images">Images</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="images[]" id="product-images" class="file-input-overview" multiple="multiple">
                            @error('images')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>  
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>

            </form>
        </div>
</div>


@push('scripts')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {

            //select 2
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function (idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            $('.select2').select2({
                minimumResultsForSearch: Infinity,
                tags: true,
                closeOnSelect: false,
                match: matchStart
            });

            
            //summernote
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


            //bootstrap fileinput
            $('#product-images').fileinput({
                theme: "fas",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,

                initialPreview: [
                    @if($product->media()->count() > 0)
                        @foreach ($product->media as $media)
                        "{{ asset('assets/products/' . $media->file_name) }}",
                        @endforeach
                    @endif    
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($product->media()->count() > 0)
                        @foreach ($product->media as $media)
                            {
                                caption: "{{ $media->file_name }}",
                                size: "{{ $media->file_size }}", 
                                width: "120px", 
                                url: "{{ route('admin.products.remove_image', ['image_id' => $media->id, 'product_id' => $product->id, '_token' => csrf_token()]) }}", 
                                key: {{ $media->id }},
                            },
                        @endforeach
                    @endif
                ]
            });
        });
    </script>
@endpush
@endsection
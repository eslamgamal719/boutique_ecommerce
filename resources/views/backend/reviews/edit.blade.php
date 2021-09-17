@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Review on product ({{ $review->product->name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        
                    </span>
                    <span class="text">Reviews</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="post">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $review->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email', $review->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                

                    <div class="col-4">
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select name="rating" class="form-control">
                                <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : ''}}>1</option>
                                <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : ''}}>2</option>
                                <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : ''}}>3</option>
                                <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : ''}}>4</option>
                                <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : ''}}>5</option>
                            </select>
                            @error('rating')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <input type="text" class="form-control" value="{{ $review->product->name }}" readonly>
                            <!-- to use request->validated in update used this lower field -->
                            <input type="hidden" name="product_id" class="form-control" value="{{ $review->product_id }}" readonly> 
                            @error('product_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="user_id">Customer</label>
                            <input type="text" class="form-control" value="{{ $review->user_id != '' ? $review->user->full_name : '' }}" readonly>
                            <input type="hidden" name="user_id" class="form-control" value="{{ $review->user_id ?? '' }}" readonly>
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $review->status) == '1' ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status', $review->status) == '0' ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $review->title }}">
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea type="text" class="summernote" name="message" class="form-control">{{ $review->message }}</textarea>
                            @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update Review</button>
                </div>

            </form>
        </div>
</div>


@push('scripts')
    <script>
        $(function() {
            $('.summernote').summernote({
                tabSize: 2,
                height: 150,
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
        });
    </script>
@endpush
@endsection
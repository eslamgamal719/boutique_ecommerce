@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
            <div class="ml-auto">

                @can('create_category')
                <!-- <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new category</span>
                </a> -->
                @endcan

            </div>
        </div>

        @include('backend.reviews.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Rating</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                    <tr>
                        <td>
                            {{ $review->name }}<br>
                            {{ $review->email }}<br>
                            <small>{{ $review->user_id != '' ? $review->user->full_name : '' }}</small>
                        </td>
                        <td>
                            {{ $review->title }}<br>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ $review->rating }}</span>
                        </td>
                        <td>{{ $review->product->name }}</td>
                        <td>{{ $review->status() }}</td>
                        <td>{{ $review->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $review->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="post" id="form-delete-{{ $review->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No reviews found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="float-right">
                                {!! $reviews->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
@extends('layouts.backend.app')
@section('content')

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
            <div class="ml-auto">

                @can('create_category')
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                    </span>
                    <span class="text">Reviews</span>
                </a> 
                @endcan

            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $review->name }}</td>
                        <th>Email</th>
                        <td>{{ $review->email }}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $review->user_id != '' ? $review->user->full_name : '' }}</td>
                        <th>Rating</th>
                        <td>{{ $review->rating }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td colspan="3">{{ $review->title }}</td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td colspan="3">{{ $review->message }}</td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td colspan="3">{{ $review->created_at->format('Y-m-d') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
</div>

@endsection
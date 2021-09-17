@extends('layouts.backend.app')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Products</h6>
            <div class="ml-auto">

                @can('create_product')
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new product</span>
                </a>
                @endcan

            </div>
        </div>

        @include('backend.products.filters.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Feature</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Tags</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>
                            @if($product->media->first())
                                <img src="{{ asset('assets/products/' . $product->media->first()->file_name) }}" width="60" height="60" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('assets/default.jpg') }}" width="60" height="60" alt="{{ $product->name }}">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->feature() }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            @foreach($product->tags as $tag)
                                <span class="badge badge-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $product->status() }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn btn-danger"
                                 onclick="if(confirm('Are you sure to delete this record ?')) { getElementById('form-delete-{{ $product->id }}').submit();} else { return false; }"><i class="fa fa-trash"></i></a>
                            </div>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" id="form-delete-{{ $product->id }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $products->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
 
@endsection
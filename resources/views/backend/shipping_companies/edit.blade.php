@extends('layouts.backend.app')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endpush


<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Shipping company ({{ $shipping_company->full_name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.shipping_companies.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>  
                    <span class="text">Shipping Companies</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.shipping_companies.update', $shipping_company->id) }}" method="post">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $shipping_company->id }}">

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $shipping_company->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" value="{{ old('code', $shipping_company->code) }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" value="{{ old('description', $shipping_company->description) }}" class="form-control">
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                <div class="col-4">
                        <div class="form-group">
                            <label for="fast">Fast</label>
                            <select name="fast" class="form-control">
                                <option value="1" {{ old('fast', $shipping_company->fast) == '1' ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{ old('fast', $shipping_company->fast) == '0' ? 'selected' : ''}}>No</option>
                            </select>
                            @error('fast')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="text" name="cost" value="{{ old('cost', $shipping_company->cost) }}" class="form-control">
                            @error('cost')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $shipping_company->status) == '1' ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status', $shipping_company->status) == '0' ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="countries">Countries</label>
                            <select name="countries[]" class="form-control select2" multiple>
                                @forelse ($countries as $country)
                                    <option value="{{ $country->id }}" {{ in_array($country->id, old('countries', $shipping_company->countries->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $country->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('countries')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update shipping company</button>
                </div>

            </form>
        </div>
</div>


@push('scripts')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {

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




            $('#supervisor-image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,

                initialPreview: [
                    @if ($shipping_company->user_image != '')
                        "{{ asset('assets/supervisors/' . $shipping_company->user_image) }}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($shipping_company->user_image != '')
                    {
                        caption: "{{ $shipping_company->user_image }}",
                        size: "1111",
                        width: "120px",
                        url: "{{ route('admin.shipping_companies.remove_image', ['supervisor_id' => $shipping_company->id, '_token' => csrf_token()]) }}",
                        key: {{ $shipping_company->id }}

                    }
                    @endif
                ]
            });
        });
    </script>
@endpush
@endsection
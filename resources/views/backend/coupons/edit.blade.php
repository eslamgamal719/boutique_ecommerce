@extends('layouts.backend.app')
@section('content')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/vendor/datepick/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/datepick/themes/classic.date.css') }}">
    <style>
        .picker__select--month, .picker__select--year {
            padding: 0 !important;
        }
    </style>
@endpush

<div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit coupon ({{ $coupon->code }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Coupons</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post">
                @csrf
                @method('PATCH')

                <input type="hidden" name="id" value="{{ $coupon->id }}">

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                

                    <div class="col-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" class="form-control">
                                <option value="">---</option>
                                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                            @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" value="{{ old('value', $coupon->value) }}" class="form-control">
                            @error('value')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="use_times">Use times</label>
                            <input type="number" name="use_times" value="{{ old('use_times', $coupon->use_times) }}" class="form-control">
                            @error('use_times')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            <input type="text" name="start_date" id="start_date" value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}" class="form-control">
                            @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="expire_date">Expire date</label>
                            <input type="text" name="expire_date" id="expire_date" value="{{ old('expire_date', $coupon->expire_date->format('Y-m-d')) }}" class="form-control">
                            @error('expire_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="greater_than">Greater than</label>
                            <input type="number" name="greater_than" value="{{ old('greater_than', $coupon->greater_than) }}" class="form-control">
                            @error('greater_than')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $coupon->status) == '1' ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ old('status', $coupon->status) == '0' ? 'selected' : ''}}>Inactive</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="summernote" class="form-control"rows="3">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div> 

                <div class="form-group pt-4">
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>

            </form>
        </div>
</div>

@push('scripts')
    <script src="{{ asset('backend/vendor/datepick/picker.js') }}"></script>
    <script src="{{ asset('backend/vendor/datepick/picker.date.js') }}"></script>
    <script>
        $(function() {
            
            $('#code').keyup(function() {
                this.value = this.value.toUpperCase();
            });


            $('#start_date').pickadate({
                format: 'yyyy-mm-dd',  
                selectMonths: true,   //create a dropdown to choose month
                selectYears: true,    //create a dropdown to choose Year
                clear: 'Clear',
                close: 'Close',
                closeOnSelect: true   //close after selecting a date
            });

            $('#expire_date').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),       //default today's date
                selectMonths: true,   //create a dropdown to choose month
                selectYears: true,    //create a dropdown to choose Year
                clear: 'Clear',
                close: 'Ok',
                closeOnSelect: true   //close after selecting a date
            });

            var startDate = $('#start_date').pickadate('picker');
            var endDate = $('#expire_date').pickadate('picker');

            $('#start_date').change(function() {
                selected_start_date = $('#start_date').val();
                if(selected_start_date != null) {
                    start_date = new Date(selected_start_date);
                    min_end_date = new Date();
                    min_end_date.setDate(start_date.getDate() + 1); //min = start_date + one day
                    endDate.set('min', min_end_date);
                }
            });


            $('#summernote').summernote({
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
        });
    </script>
@endpush
@endsection
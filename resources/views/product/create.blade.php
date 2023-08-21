@extends('layouts.frontend')


@section('content')



<div class="page-content">
    <div class="container-fluid">
      

        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Product Create</h4>

            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">

                    <a href="{{ route('dashboard') }}" style="float:right;" title="Back" class="btn btn-primary"><i aria-hidden="true" class="fa fa-arrow"></i> Back
                    </a>

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="card-body">
                            <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data" class="form-horizontal" id="my_form" autocomplete="on">
                                @csrf

                                <div class="row ">
                                   
                                  

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Product Name<small class="text-danger required">*</small></label>
                                            <input name="name" type="text" id="name" class="form-control" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price" class="control-label">Product Price<small class="text-danger required">*</small></label>
                                            <input name="price" type="number" id="price" class="form-control" value="{{ old('price') }}">
                                            @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="description" class="control-label">Product Description<small class="text-danger required"></small></label>
                                            <textarea name="description" type="text" id="description" class="form-control">{{old('description')}}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                    </div>

                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image" class="control-label">Product Image</label>
                                        <input name="image" type="file" id="image" class="form-control">
                                        <small>Allowed File Formats: jpg, jpeg, png</small>
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                                    
                                    


                                    <div class="col-md-12 no-label">
                                        <div class="form-group" style="float: right;">
                                            <input type="submit" value="Save" class="btn btn-primary">
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@extends('cms.parent')
@section('title', 'Update')
@section('page-title', 'Update Cities')
@section('main-page-title', 'City')
@section('small-page-title', 'Update')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update City</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('cities.update', $city->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors -> any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li> {{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <div>
                                        {{session()->get('message')}}
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                            <label for="exampleInputEmail1">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" name="name" placeholder="Enter City Name ..." value="@if(old('name')) {{old('name')}} @else {{$city->name}} @endif" >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-primary" href="{{route('cities.index')}}"><i class="fas fa-eye mr-1"></i>Show Cities</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection

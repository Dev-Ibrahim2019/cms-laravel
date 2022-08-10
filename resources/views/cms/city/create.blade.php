@extends('cms.parent')
@section('title', 'Create')
@section('page-title', 'Create Cities')
@section('main-page-title', 'City')
@section('small-page-title', 'Create')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add City</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('cities.store')}}" method="POST">
                @csrf
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
                    <label for="name">Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter City Name ..." value="{{old('name')}}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-primary" href="{{route('cities.index')}}"><i class="fas fa-eye mr-1"></i>Show Cities</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

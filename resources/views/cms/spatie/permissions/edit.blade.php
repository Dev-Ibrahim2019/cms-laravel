@extends('cms.parent')
@section('title', 'Update')
@section('page-title', 'Update Permission')
@section('main-page-title', 'Permission')
@section('small-page-title', 'Update')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Permission</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Permission Name ..." value="{{$permission->name}}">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" @checked($permission->active)>
                            <label class="custom-control-label" for="active">Active</label>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="update({{$permission->id}})">Update</button>
                    <a class="btn btn-primary" href="{{route('categories.index')}}"><i class="fas fa-eye mr-1"></i>Show Categories</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    function update(id) {
        axios.put('/cms/admin/permissions/'+id, {
            name: document.getElementById('name').value,
            active: document.getElementById('active').checked
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('create-form').reset();
        })
        .catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message)
        })
        .then(function () {
            // always executed
        });
    }
</script>
@endsection

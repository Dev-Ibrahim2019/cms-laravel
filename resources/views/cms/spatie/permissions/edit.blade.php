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
                        <label>Guard</label>
                        <select class="form-control guards" id="guard" style="width: 100%;">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name"
                            placeholder="Enter Permission Name" value="{{$permission->name}}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="update({{$permission->id}})">Update</button>
                    <a class="btn btn-primary" href="{{route('permissions.index')}}"><i class="fas fa-eye mr-1"></i>Show Permissions</a>
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
            guard_name: document.getElementById('guard').value
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

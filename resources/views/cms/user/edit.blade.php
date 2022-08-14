@extends('cms.parent')
@section('title', 'Update')
@section('page-title', 'Update User')
@section('main-page-title', 'User')
@section('small-page-title', 'Update')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter User Name ..." value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter Category Email ..." value="{{$user->email}}">
                    </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" @if ($user->id == auth('user')->id()) disabled @endif id="active" @checked($user->active)>
                                <label class="custom-control-label" for="active">Active</label>
                            </div>
                        </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="update({{$user->id}})">Update</button>
                    <a class="btn btn-primary" href="{{route('users.index')}}"><i class="fas fa-eye mr-1"></i>Show Users</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    function update(id) {
        axios.put('/cms/admin/users/'+id, {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            active: document.getElementById('active').checked
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('create-form').reset();
            // window.location.href = '/cms/user/index'
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


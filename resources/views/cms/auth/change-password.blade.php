@extends('cms.parent')
@section('title', 'Edit')
@section('page-title', 'Change Password')
@section('main-page-title', 'Password')
@section('small-page-title', 'Edit')
@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="create-form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="current_password">Current Password:</label>
                        <input type="password" class="form-control" id="current_password" placeholder="Current Password" value="{{old('current_password')}}">
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" class="form-control" id="new_password" placeholder="New Password" value="{{old('new_password')}}">
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">New Password Confirmation:</label>
                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="New Password Confirmation" value="{{old('new_password_configration')}}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="updatePassword()" >Change Password</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    function updatePassword() {
        axios.put('/cms/admin/update-password', {
            current_password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value,
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

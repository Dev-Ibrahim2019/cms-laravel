@extends('cms.parent')
@section('title', 'Create')
@section('page-title', 'Create Role')
@section('main-page-title', 'Role')
@section('small-page-title', 'Create')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Role</h3>
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
                                        placeholder="Enter Role Name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-primary" type="button" onclick="store()">Store</button>
                                <a class="btn btn-primary" href="{{ route('roles.index') }}"><i
                                        class="fas fa-eye mr-1"></i>Show Roles</a>
                            </div>
                        </form>
                    </div>
                </div>
    </section>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        // $('.guards').select2()
        $('.guards').select2({
            theme: 'bootstrap4'
        })

        function store() {
            axios.post('/cms/admin/roles', {
                    name: document.getElementById('name').value,
                    guard_name: document.getElementById('guard').value
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message)
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endsection

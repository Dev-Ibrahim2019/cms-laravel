@extends('cms.parent')
@section('title', 'Role Permissions')
@section('page-title', 'Display Role Permissions')
@section('main-page-title', 'Role Permissions')
@section('small-page-title', 'Index')
@section('style')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$role->name}} Permissions</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->name}}</td>
                                        <td>
                                            <span class="badge bg-success">{{$permission->guard_name}}</span>
                                        </td>
                                        <td>
                                            <div class="icheck-primary d-inline">
                                                <input onchange="(assignPermission({{$role->id}}, {{$permission->id}}))" type="checkbox" id="permission_{{$permission->id}}" @if($permission->assigned) checked @endif>
                                                <label for="permission_{{$permission->id}}">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                {{-- <div class="container">
                    {{$permissions->links()}}
                </div> --}}
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function assignPermission(roleId, permissionId){
        axios.post('/cms/admin/roles/'+roleId+'/permissions/', {
            permission_id: permissionId
        })
        .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message);
        })
    }
</script>
@endsection

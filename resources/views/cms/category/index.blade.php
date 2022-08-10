@extends('cms.parent')
@section('title', 'Index')
@section('page-title', 'Display Categories')
@section('main-page-title', 'Category')
@section('small-page-title', 'Index')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <a class="btn btn-primary px-4" href="{{route('categories.create')}}"><i class="fas fa-plus-circle mr-1"></i>Add Category</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                {{-- {{dd($category)}} --}}
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        {{-- <td>@if($category->active) {{'Active'}} @else {{'Disabled'}} @endif</td> --}}
                                        <td><span class="badge @if($category->active) bg-success @else bg-danger @endif ">{{$category->status}}</span></td>
                                        <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td>
                                            <div class="d-flex ">
                                                <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger" onclick="confirmDestroy({{$category->id}}, this)"><i class="fas fa-trash-alt"></i></a>
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
                <div class="container">
                    {{$categories->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function confirmDestroy(id, reference) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(id, reference);
            }
        })
    }

    function destroy(id, reference){
        axios.delete('/cms/admin/categories/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            reference.closest('tr').remove();
            showMessage(response.data)
        })
        .catch(function (error) {
            // handle error
            console.log(error);
            showMessage(error.response.data);
        })
        .then(function () {
            // always executed
        });
    }

    function showMessage(data){
        Swal.fire({
            icon: data.icon,
            title: data.title,
            showConfirmButton: false,
            timer: 1500
        })
    }
</script>
@endsection

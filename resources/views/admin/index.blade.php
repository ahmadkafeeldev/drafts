@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>User List</h4>
            @if(session()->has('message'))
                <div class="alert alert-success text-center">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger text-center">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
        <div class="col-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route ('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User List</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Users Data</h6>
                    <!-- <a href="" class="btn btn-primary">Add User</a> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add User</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Name</th>                                   
                                    <th>Email</th>                                  
                                    <th>Phone</th>  
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Name</th>                                 
                                    <th>Email</th>                                 
                                    <th>Phone</th> 
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($users as $key=>$user)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                                <img class="img-profile rounded-circle btn-circle"
                                                    src="{{ asset($user->profile_image) }}">
                                                {{ $user->first_name }}&nbsp {{$user->last_name}}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>                                            
                                            <div class="row pl-3">                                                    
                                                <div class = "col-md-2 col-6">
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type = "submit" name = "submit" value = "submit" data-toggle="tooltip" title="Delete User" onclick = "return confirm('Do You Really Want to Delete?')" class = "btn btn-sm btn-circle btn-outline-danger" style = "margin-left: -10px;"><i class = "fa fa-trash"></i></button>
                                                    </form>
                                                </div> 
                                            </div>                                           
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" >
                              @csrf  
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 First Name</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="first_name"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_title" class="col-sm-3 col-form-label"
                                    >Last Name</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="last_name"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_title" class="col-sm-3 col-form-label"
                                    >Email</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="email"
                                       class="form-control"
                                       name="email"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_title" class="col-sm-3 col-form-label"
                                    >Phone Number</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="number"
                                       class="form-control"
                                       name="phone"
                                       required
                                       />
                                 </div>
                              </div>
                              <!-- div class="form-group row">
                                 <label for="p_title" class="col-sm-3 col-form-label"
                                    >Profile Image</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="file"
                                       class="form-control"
                                       name="image"
                                       required
                                       />
                                 </div>
                              </div>
 -->                          <div class="form-group row">
                                 <label for="p_title" class="col-sm-3 col-form-label"
                                    >Enter Password</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="password"
                                       class="form-control"
                                       name="Password"
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                  <button type="submit" class="w-100 btn btn-primary">Add</button>
                              </div>
                              
                           </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
        </div>
    </div> 
</div> 
    
@endsection
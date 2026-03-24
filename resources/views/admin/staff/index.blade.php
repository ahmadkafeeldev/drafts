@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>Staff List</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">Staff List</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Staff Data</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Staff</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>First Name</th>
                                    <th>Last Name</th>                 
                                    <!-- <th>Company Name</th>                  -->
                                    <th>Email</th>  
                                     <th>Action</th> 
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>First Name</th>                    
                                    <th>Last Name</th>            
                                    <!-- <th>Company Name</th>                           -->
                                    <th>Email</th> 
                                     <th>Action</th> 
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($users as $key=>$user)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                                <!--<img class="img-profile rounded-circle btn-circle"-->
                                                    <!--src="{{ asset($user->profile_image) }}">-->
                                                {{ $user->first_name }}
                                        </td>
                                        <td>{{ $user->last_name }}</td>
                                        <!-- <td>{{ $user->company_name }}</td> -->
                                        <td>{{ $user->email }}</td>
                                         <td>                                            
                                            <div class="row pl-3">                                                    
                                                
                                                <div class = "col-md-2 col-6">
                                                    <form action="{{ route('admin.staff.destroy', $user->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type = "submit" name = "submit" value = "submit" data-toggle="tooltip" title="Delete Staff" onclick = "return confirm('Do You Really Want to Delete This Staff?')" class = "btn btn-sm btn-circle btn-outline-danger" style = "margin-left: -10px;"><i class = "fa fa-trash"></i></button>
                                                    </form>
                                                </div> 
                                                
                                                <div class="col-md-2 ml-1">
                                                    <button type="button" name="edit" data-toggle="modal" data-target="#editNewsPaperModal{{ $user->id }}" title="Edit" 
                                                    class="btn btn-sm btn-circle btn-outline-primary ml-1" style="margin-left: -10px;">
                                                        <i class="fa fa-pen"></i>
                                                    </button>
                                                </div>
                                                
                                            </div>                                           
                                        </td>
                                    </tr>
                                    
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editNewsPaperModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editNewsPaperModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-primary" id="editNewsPaperModalLabel{{ $user->id }}">Edit News Paper</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.staff.update', $user->id) }}" method="POST">
                                                        @csrf  
                                                        @method('PUT')
                                                        <div class="form-group row">
                                                            <label for="name{{ $user->id }}" class="col-sm-3 col-form-label">First Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="first_name" id="name{{ $user->id }}" value="{{ $user->first_name }}" required />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <label for="name{{ $user->id }}" class="col-sm-3 col-form-label">First Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="last_name" id="name{{ $user->id }}" value="{{ $user->last_name }}" required />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <label for="name{{ $user->id }}" class="col-sm-3 col-form-label">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="email" id="name{{ $user->id }}" value="{{ $user->email }}" required />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <button type="submit" class="w-100 btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add New Staff</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" >
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
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Last Name</label
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
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Email</label
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
                                <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Password</label
                                    >
                                <div class="col-sm-9">
                                    <span>Staff Default Password Is 1-8.</span>
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
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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>First Name</th>
                                    <th>Last Name</th>                 
                                    <th>Company Name</th>                 
                                    <th>Email</th>  
                                     <th>Action</th> 
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>First Name</th>                    
                                    <th>Last Name</th>            
                                    <th>Company Name</th>                          
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
                                        <td>{{ $user->company_name }}</td>
                                        <td>{{ $user->email }}</td>
                                         <td>                                            
                                            <div class="row pl-3">                                                    
                                                <div class = "col-md-2 col-6">
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type = "submit" name = "submit" value = "submit" data-toggle="tooltip" title="Disable User" onclick = "return confirm('Do You Really Want to Disable?')" class = "btn btn-sm btn-circle btn-outline-danger" style = "margin-left: -10px;"><i class = "fa fa-trash"></i></button>
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
            </div>
        </div>
    </div> 
</div> 
    
@endsection
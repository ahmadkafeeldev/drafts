@extends('layouts.staff.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>My Notices Report</h4>
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
                    <li class="breadcrumb-item"><a href="{{route ('user.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Notices Report</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">My Notices Report Data</h6>
                     <a href="{{ route('user.download_all_bookings') }}"><button type="button" class="btn btn-primary">Download All <i class="fa fa-download"></i></button> </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>  
                                    <th>Borough</th>                    
                                    <th>Total Notices</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Borough</th>                    
                                    <th>Total Notices</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($boroughs as $key=>$borough)
                                    @if($borough->total_bookings > 0)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $borough->name }}</td>
                                        <td>{{ $borough->total_bookings }}</td>
                                        <td>{{ $borough->total_amount }}</td>
                                        
                                        <td>                                            
                                            <div class="row pl-3">                                                    
                                                <div class = "col-md-6 col-6">
                                                    <a href="{{ route('user.report.show', $borough->id) }}" class = "btn btn-primary">View Notices</a>
                                                </div> 
                                            </div>                                           
                                        </td>
                                    </tr>
                                    @endif
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
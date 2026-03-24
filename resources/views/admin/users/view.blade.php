@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-4 offset-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route ('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route ('admin.users.index')}}">User List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->first_name }}'s</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success text-center alert-dismissible " role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger text-center alert-dismissible" role="alert">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <!-- user detail  -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $user->first_name }}'s Detail</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img class="img-profile rounded-circle topbar mb-2"
                                src="{{ asset($user->profile_image) }}">
                            <p class="mb-0">{{ $user->first_name }}&nbsp {{$user->last_name}}</p>
                            <p class="mb-0">{{$user->created_at->format('d M Y');}}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-fw fa-envelope icon"></i>
                                        </span>
                                        {{$user->email}}
                                    </p>
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-fw fa-phone"></i>
                                        </span>
                                        {{$user->country_code}} {{$user->phone}}
                                    </p>
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Total Payments">
                                            <i class="fa fa-fw fa-credit-card"></i>
                                        </span>
                                        {{$totalPayment}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Total Rides">
                                            <i class="fas fa-fw fa-users"></i>
                                        </span>
                                        {{count($userRides)}}
                                    </p>
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Total Booking">
                                            <i class="fas fa-fw fa-id-card"></i>
                                        </span>
                                        {{$userBooking}}
                                    </p>
                                    <p>
                                        <span class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Total Vahivles">
                                            <i class="fas fa-fw fa-car"></i>
                                        </span>
                                        {{count($userVehicles)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Vehicle Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $user->first_name }}'s Vehicles</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Brand</th>                                        
                                    <th>Modal</th>                                      
                                    <th>No Plate</th>  
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Brand</th>                                        
                                    <th>Modal</th>                                      
                                    <th>No Plate</th>  
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($userVehicles as $key=>$vehicle)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $vehicle->brand_name }}</td>
                                        <td>{{ $vehicle->model_name }}</td>
                                        <td>{{ $vehicle->number_plate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            <!-- User Rides Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $user->first_name }}'s Rides</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Title</th>                                        
                                    <th>Type</th>                                        
                                    <th>Description</th>                                      
                                    <th>Seats</th>   
                                    <th>Departure</th>  
                                    <th>Arrival</th>   
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Title</th>                                        
                                    <th>Type</th>                                        
                                    <th>Description</th>                                      
                                    <th>Seats</th>   
                                    <th>Departure</th>  
                                    <th>Arrival</th>  
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($userRides as $key=>$rides)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.user.ride', ['id' => $user->id, 'ride_id' => $rides->id]) }}">
                                                {{ $rides->ride_title }}
                                            </a>
                                        </td>
                                        <td>{{ $rides->ride_type }}</td>
                                        <td>{{ $rides->description }}</td>
                                        <td>{{ $rides->number_of_seats }}</td>
                                        <td>{{ $rides->departure_city }}</td>
                                        <td>{{ $rides->arrival_city }}</td>
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
</div> 
    
@endsection
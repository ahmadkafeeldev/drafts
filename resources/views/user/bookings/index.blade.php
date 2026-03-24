@extends('layouts.user.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>My Notices</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">My Notices</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">My Notices Data</h6>
                     <a href="{{route ('user.bookings.create')}}"><button type="button" class="btn btn-primary">Add New</button> </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <!--<th>Client Name</th>-->
                                    <!--<th>Client Email</th>                        -->
                                    <th>News Paper</th>
                                    <th>Title</th>
                                    <th>Area</th>
                                    <th>Gazette</th>
                                    <th>Borough</th>
                                    <th>Price</th>
                                    <th>Submission Date</th>
                                    <th>Booking Date</th>
                                    <th>Publish Date</th>
                                    <th>Attached Document</th>
                                    <th>Traffic Order Type</th>
                                    <th>Notice Type</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Proof Reading Document</th>
                                    <th>Proof Document Status</th>
                                    <th>Document Approved/Reject</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <!--<th>Client Name</th>-->
                                    <!--<th>Client Email</th>                        -->
                                    <th>News Paper</th>
                                    <th>Title</th>
                                    <th>Area</th>
                                    <th>Gazette</th>
                                    <th>Borough</th>
                                    <th>Price</th>
                                    <th>Submission Date</th>
                                    <th>Booking Date</th>
                                    <th>Publish Date</th>
                                    <th>Attached Document</th>
                                    <th>Traffic Order Type</th>
                                    <th>Notice Type</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Proof Reading Document</th>
                                    <th>Proof Document Status</th>
                                    <th>Document Approved/Reject</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </tfoot>
                            <tbody>
                               @foreach($bookingDetails as $key => $detail)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                
                                        <!-- Access user details from the associative array -->
                                        <td>{{ $detail['user_details']->first_name ?? '' }}</td>
                                        <td>{{ $detail['user_details']->email ?? '' }}</td>
                                
                                        <!-- Access other details directly from the associative array -->
                                        <td>{{ $detail['news_paper_name'] }}</td>
                                        <td>{{ $detail['booking']->title }}</td>
                                        <td>{{ $detail['area_name'] }}</td>
                                        <td>{{ $detail['booking']->london_gazette }}</td>
                                        <td>{{ $detail['borough_name'] }}</td>
                                        <td>{{ $detail['booking']->price }}</td>
                                        <td>{{ $detail['booking']->created_at }}</td>
                                
                                        <!-- Access booking date and publish date from the booking object -->
                                        <td>{{ $detail['booking']->booking_date ?? '' }}</td>
                                        <td>{{ $detail['booking']->publish_date ?? '' }}</td>
                                
                                        <!-- Check if document exists and provide a link -->
                                        <td>
                                            @if(!empty($detail['booking']->document))
                                                <a href="{{ asset($detail['booking']->document) }}" target="_blank">{{ asset($detail['booking']->document) }}</a>
                                            @endif
                                        </td>
                                
                                        <td>{{ $detail['booking']->booking_type }}</td>
                                        <td>{{ $detail['booking']->notice_type }}</td>
                                        <td>{{ $detail['booking']->status }}</td>
                                        <td>{{ $detail['booking']->payment_status }}</td>
                                
                                        <!-- Check if proof PDF exists and provide a link -->
                                        <td>
                                            @if(!empty($detail['booking']->proof_pdf))
                                                <a href="{{ asset($detail['booking']->proof_pdf) }}" target="_blank">{{ asset($detail['booking']->proof_pdf) }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $detail['booking']->pdf_status }}</td>
                                
                                        <td class="d-flex justify-content-center align-items-center">
                                            @if(!empty($detail['booking']->proof_pdf))
                                                <div class="text-center">
                                                    <!-- Dropdown Button -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-md btn-outline-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cogs"></i> Approved/Reject
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="{{ route('user.update_proof_doc_status', ['booking_id' => $detail['booking']->id, 'doc_status' => 'Approved']) }}">
                                                                <button type="button" class="dropdown-item" onclick="return confirm('Do You Really Want to Approve This Document?')">
                                                                    <i class="fa fa-check"></i> Approved
                                                                </button>
                                                            </a>
                                                            <a href="{{ route('user.update_proof_doc_status', ['booking_id' => $detail['booking']->id, 'doc_status' => 'Reject']) }}">
                                                                <button type="button" class="dropdown-item" onclick="return confirm('Do You Really Want to Reject This Document?')">
                                                                    <i class="fa fa-times"></i> Reject
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
@extends('layouts.user.app')
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
                    <h6 class="m-0 font-weight-bold text-primary">Report Data</h6>
                     <a href="{{ route('user.download_borough_bookings',$borough_id) }}"><button type="button" class="btn btn-primary">Download <i class="fa fa-download"></i></button> </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>News Paper</th>
                                    <th>Title</th>
                                    <th>Area</th>
                                    <th>Borough</th>
                                    <th>Price</th>
                                    <th>Submission Date</th>
                                    <th>Booking Date</th>
                                    <th>Publish Date</th>
                                    <th>Attached Document</th>
                                    <th>Traffic Order Type</th>
                                    <th>Notice Type</th>
                                    <th>Proof Reading Document</th>
                                    <th>Proof Document Status</th>
                                    <th>Payment Status</th>
                                    <th>Progress Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>News Paper</th>
                                    <th>Title</th>
                                    <th>Area</th>
                                    <th>Borough</th>
                                    <th>Price</th>
                                    <th>Submission Date</th>
                                    <th>Booking Date</th>
                                    <th>Publish Date</th>
                                    <th>Attached Document</th>
                                    <th>Traffic Order Type</th>
                                    <th>Notice Type</th>
                                    <th>Proof Reading Document</th>
                                    <th>Proof Document Status</th>
                                    <th>Payment Status</th>
                                    <th>Progress Status</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($bookings as $key=>$booking)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $booking->news_paper }}</td>
                                        <td>{{ $booking->title }}</td>
                                        <td>{{ $booking->area }}</td>
                                        <td>{{ $booking->borough }}</td>
                                        <td>{{ $booking->price }}</td>
                                        <td>{{ $booking->created_at }}</td>
                                        <td>{{ $booking->booking_date }}</td>
                                        <td>{{ $booking->publish_date }}</td>
                                        <td><a href="{{ asset($booking->document) }}" target="_blank">{{ asset($booking->document) }}</a></td>
                                        <td>{{ $booking->booking_type }}</td>
                                        <td>{{ $booking->notice_type }}</td>
                                        <td>
                                            @if($booking->proof_pdf != Null)
                                            <a href="{{ asset($booking->proof_pdf) }}" target="_blank">{{ asset($booking->proof_pdf) }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $booking->pdf_status }}</td>
                                        <td>{{ $booking->payment_status }}</td>
                                        <td>{{ $booking->status }}</td>
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
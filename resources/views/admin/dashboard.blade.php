@extends('layouts.admin.app')
@section('content')
    <style>
        .bg-pending {
            background-color: #5050dd;
            color: white;
        }

        /* Orange */
        .bg-processing {
            background-color: orange;
            color: black;
        }

        /* Light Blue */
        .bg-completed {
            background-color: green;
            color: white;
        }

        /* Green */
        .bg-cancelled {
            background-color: red;
            color: white;
        }

        /* hover */
        .bg-pending:hover {
            background-color: #5050dd;
            color: white;
        }

        .bg-processing:hover {
            background-color: orange;
            color: black;
        }

        .bg-completed:hover {
            background-color: green;
            color: white;
        }

        .bg-cancelled:hover {
            background-color: red;
            color: white;
        }
    </style>

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-black font-weight-bold">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <!--<a href="#" style="text-decoration: none;">-->
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $users }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--</a>    -->
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!--<a href="#" style="text-decoration: none;">-->
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Area's</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $area }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--</a>    -->
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!--<a href="#" style="text-decoration: none;">-->
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total News Papers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $news_paper }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--</a>    -->
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <!--<a href="#" style="text-decoration: none;">-->
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Borough's</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $borough }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--</a>    -->
            </div>


        </div>

        <div class="row">
            <h1 class="h3 my-3 text-black font-weight-bold px-2">Bookings</h1>
        </div>

        <div class="row">

            @php
                $statusClasses = [
                    'pending' => 'bg-pending',
                    'processing' => 'bg-processing',
                    'completed' => 'bg-completed',
                    'cancelled' => 'bg-cancelled',
                ];
            @endphp

            @foreach ($statusClasses as $status => $class)
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('admin.bookings.index') }}" style="text-decoration: none;">
                        <div class="card {{ $class }} border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-uppercase mb-1">
                                            {{ ucfirst($status) }}</div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            {{ $bookingsCount[$status] }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-sort-numeric-desc fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Bookings Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-white" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Submission Date</th>
                                        <th>Booking Date</th>
                                        <th>Publish Date</th>
                                        <th>Attached Document</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>News Paper</th>
                                        <th>Area</th>
                                        <th>Borough</th>
                                        <th>Price</th>
                                        <th>Traffic Order Type</th>
                                        <th>Notice Type</th>
                                        <th>Proof Reading Document</th>
                                        <th>Proof Document Status</th>
                                        <th>Progress Status</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Submission Date</th>
                                        <th>Booking Date</th>
                                        <th>Publish Date</th>
                                        <th>Attached Document</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>News Paper</th>
                                        <th>Area</th>
                                        <th>Borough</th>
                                        <th>Price</th>
                                        <th>Traffic Order Type</th>
                                        <th>Notice Type</th>
                                        <th>Proof Reading Document</th>
                                        <th>Proof Document Status</th>
                                        <th>Progress Status</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                        <tr
                                            style="
                                                @if ($booking->status == 'pending') background-color: #007bff;
                                                    color: #f0f0f0; /* Alternative foreground color */
                                                @elseif ($booking->status == 'processing')
                                                    background-color: #ffc107;
                                                    color: #333333; /* Alternative foreground color */
                                                @elseif ($booking->status == 'cancelled')
                                                    background-color: #dc3545;
                                                    color: #f8f9fa; /* Alternative foreground color */
                                                @elseif ($booking->status == 'completed')
                                                    background-color: #28a745;
                                                    color: #ffffff; /* Alternative foreground color */ @endif
                                            ">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $booking->title }}</td>
                                            <td>{{ $booking->created_at }}</td>
                                            <td>{{ $booking->booking_date }}</td>
                                            <td>{{ $booking->publish_date }}</td>
                                            <td><a href="{{ asset($booking->document) }}"
                                                    target="_blank">{{ asset($booking->document) }}</a></td>
                                            <td>{{ $booking->user_details->first_name }}</td>
                                            <td>{{ $booking->user_details->email }}</td>
                                            <td>{{ $booking->news_paper }}</td>
                                            <td>{{ $booking->area }}</td>
                                            <td>{{ $booking->borough }}</td>
                                            <td>{{ $booking->price }}</td>
                                            <td>{{ $booking->booking_type }}</td>
                                            <td>{{ $booking->notice_type }}</td>
                                            <td>
                                                @if($booking->proof_pdf != Null)
                                                <a href="{{asset($booking->proof_pdf) }}"target="_blank">{{ asset($booking->proof_pdf) }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $booking->pdf_status }}</td>
                                            <!-- <td>{{$booking->status}}</td> -->
                                            
                                            <td>
                                                @if ($booking->status == 'pending')
                                                    <span class="badge text-white">Pending</span>
                                                @elseif ($booking->status == 'processing')
                                                    <span class="badge">Processing</span>
                                                @elseif ($booking->status == 'cancelled')
                                                    <span class="badge text-white">Cancelled</span>
                                                @elseif ($booking->status == 'completed')
                                                    <span class="badge text-white">Completed</span>
                                                @endif
                                            </td>
                                            <td>{{ $booking->payment_status }}</td>
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

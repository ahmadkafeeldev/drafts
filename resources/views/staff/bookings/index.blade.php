@extends('layouts.staff.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>Assigned Bookings</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">Assigned Bookings</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Bookings Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>News Paper</th>
                                    <th>Area</th>
                                    <!-- <th>Gazette</th> -->
                                    <th>Borough</th>
                                    <th>Document</th>
                                    <th>Delivery Status</th>
                                    <th>Change Delivery Status</th>
                                    <th>Delivery Proof</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th> 
                                    <th>News Paper</th>
                                    <th>Area</th>
                                    <!-- <th>Gazette</th> -->
                                    <th>Borough</th>
                                    <th>Document</th>
                                    <th>Delivery Status</th>
                                    <th>Change Delivery Status</th>
                                    <th>Delivery Proof</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </tfoot>
                            <tbody>
                               @foreach ($bookings as $key => $booking)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $booking->title }}</td>
                                    <td>{{ $booking->news_paper }}</td>
                                    <td>{{ $booking->area }}</td>
                                    <td>{{ $booking->borough }}</td>
                                    <td>
                                        @if($booking->proof_pdf != Null)
                                        <a href="{{asset($booking->proof_pdf) }}"target="_blank">{{ asset($booking->proof_pdf) }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $booking->delivery_status }}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <div class="text-center">
                                            <!-- Dropdown Button -->
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-md btn-outline-dark dropdown-toggle"
                                                    type="button"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-cogs"></i> Select Delivery Satus
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="#">
                                                    <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                        <i class="fa fa-times"></i> Pending
                                                    </button></a>

                                                    <a data-toggle="modal" data-target="#exampleModal{{ $booking->id }}">
                                                    <button type="button" class="dropdown-item">
                                                        <i class="fa fa-check"></i> Delivered
                                                    </button></a>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($booking->delivery_proof != Null)
                                        <a href="{{asset($booking->delivery_proof) }}"target="_blank">{{ asset($booking->delivery_proof) }}</a>
                                        @endif
                                    </td>

                                    <div class="modal fade" id="exampleModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add Delivery Proof Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('staff.update_delivery_status') }}" method="POST" enctype="multipart/form-data" >
                              @csrf  
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Add PDF Document</label
                                    >
                                 <div class="col-sm-9">
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="delivery_status" value="Delivered">
                                    
                                    <input
                                       type="file"
                                       class="form-control"
                                       name="delivery_proof"
                                       accept=".pdf"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                  <button type="submit" class="w-100 btn btn-primary">Submit</button>
                              </div>
                              
                           </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

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
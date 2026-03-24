@extends('layouts.admin.app')
@section('content')
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <script src="https://cdn.tiny.cloud/1/41j0mi77s41u5d7zgdk25tw0gijmr3z93w8k50cbhxr7bo01/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#tinymce-editor, #tinymce-client-notes',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            min-width: 1000px;
            /* Adjust based on your table's total width */
        }

        .mail-seccess .success-inner {
            display: inline-block;
        }

        .mail-seccess .success-inner h1 {
            font-size: 100px;
            text-shadow: 3px 5px 2px #3333;
            color: #006DFE;
            font-weight: 700;
        }

        .mail-seccess .success-inner h1 span {
            display: block;
            font-size: 25px;
            color: #333;
            font-weight: 600;
            text-shadow: none;
            margin-top: 20px;
        }

        .mail-seccess .success-inner p {
            padding: 20px 15px;
        }

        .mail-seccess .success-inner .btn {
            color: #fff;
        }

        #mail-success-container {
            width: 100%;
            max-height: 70vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .quotation-section {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .quotation-header {
            margin-bottom: 20px;
        }

        .quotation-table {
            width: 100%;
            border-collapse: collapse;
        }

        .quotation-table th,
        .quotation-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .quotation-table th {
            background-color: #f2f2f2;
        }

        .quotation-footer {
            margin-top: 20px;
        }
    </style>


    <div class="mt-3">
        <div class="row">
            <div class="col-md-9 ">
                <h4>Bookings List</h4>
                @if (session()->has('message'))
                    <div class="alert alert-success text-center">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger text-center">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bookings List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Bookings Data</h6>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                        <th>Change Progress Status</th>
                                        <th>Payment Status</th>
                                        <th>Change Payment Status</th>
                                        <th>Assign To</th>
                                        <th>Change Assign</th>
                                        <th>Delivery Status</th>
                                        <th>Delivery Proof</th>
                                        <th>Action</th>
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
                                        <th>Change Progress Status</th>
                                        <th>Payment Status</th>
                                        <th>Change Payment Status</th>
                                        <th>Assign To</th>
                                        <th>Change Assign</th>
                                        <th>Delivery Status</th>
                                        <th>Delivery Proof</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $booking->title ?? $booking->work_title }}</td>
                                            <td>{{ $booking->created_at }}</td>
                                            <td>{{ $booking->booking_date }}</td>
                                            <td>{{ $booking->publish_date }}</td>
                                            <td><a href="{{ asset($booking->document) }}"
                                                    target="_blank">{{ asset($booking->document) }}</a></td>
                                            <td>{{ $booking->user_details->first_name }} {{ $booking->user_details->last_name }}</td>
                                            <td>{{ $booking->user_details->email }}</td>
                                            <td>{{ $booking->news_paper }}</td>
                                            <td>{{ $booking->area }}</td>
                                            <td>{{ $booking->borough }}</td>
                                            <td>{{ $booking->currency_symbol }} {{ $booking->price == Null ? 0 : $booking->price  }}</td>
                                            <td>{{ $booking->booking_type }}</td>
                                            <td>{{ $booking->notice_type }}</td>
                                            <td>
                                                @if($booking->proof_pdf != Null)
                                                <a href="{{asset($booking->proof_pdf) }}"target="_blank">{{ asset($booking->proof_pdf) }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $booking->pdf_status }}</td>
                                            <td>{{$booking->status}}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <!-- Dropdown Button -->
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-md btn-outline-dark dropdown-toggle"
                                                            type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-cogs"></i> Select Satus
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="{{ route('admin.update_booking_status', ['booking_id'=>$booking->id,'booking_status'=>'processing']) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                                <i class="fa fa-check"></i> Processing
                                                            </button></a>

                                                            <a href="{{ route('admin.update_booking_status', ['booking_id'=>$booking->id,'booking_status'=>'completed']) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                                <i class="fa fa-check"></i> Completed
                                                            </button></a>

                                                            <a href="{{ route('admin.update_booking_status', ['booking_id'=>$booking->id,'booking_status'=>'cancelled']) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                                <i class="fa fa-times"></i> Cancelled
                                                            </button></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- <td>{{$booking->status}}</td> -->
                                            <td>{{ $booking->payment_status }}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <!-- Dropdown Button -->
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-md btn-outline-dark dropdown-toggle"
                                                            type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-cogs"></i> Select Satus
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="{{ route('admin.update_booking_status', ['booking_id'=>$booking->id,'booking_status'=>'Paid']) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                                <i class="fa fa-check"></i> Paid
                                                            </button></a>

                                                            <a href="{{ route('admin.update_booking_status', ['booking_id'=>$booking->id,'booking_status'=>'Unpaid']) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want to Change This Booking Status?')">
                                                                <i class="fa fa-times"></i> Unpaid
                                                            </button></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $booking->assign_to == Null ? '' : $booking->assign_to->first_name  }} {{ $booking->assign_to == Null ? '' : $booking->assign_to->last_name  }}</td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <!-- Dropdown Button -->
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-md btn-outline-dark dropdown-toggle"
                                                            type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fa fa-cogs"></i> Select Staff
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @foreach ($staff as $staf)
                                                            <a href="{{ route('admin.assign_staff', ['booking_id'=>$booking->id,'staff_id'=>$staf->id]) }}">
                                                            <button type="button" class="dropdown-item" onclick = "return confirm('Do You Really Want To Assign This Staff?')">
                                                                <i class="fa fa-user"></i> {{$staf->first_name}} {{$staf->last_name}}
                                                            </button></a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $booking->delivery_status }}</td>
                                            <td>
                                                @if($booking->delivery_proof != Null)
                                                <a href="{{asset($booking->delivery_proof) }}"target="_blank">{{ asset($booking->delivery_proof) }}</a>
                                                @endif
                                            </td>
                                            <td>

                                                <div class="row">
                                                    <!-- <div class = "col-md-12 col-12"> -->
                                                        <!-- <form action="{{ route('admin.bookings.destroy', $booking->id) }}" -->
                                                            <!-- method = "POST"> -->
                                                            <!-- {{ csrf_field() }} -->
                                                            <!-- {{ method_field('DELETE') }} -->
                                                            <!-- <button type = "submit" name = "submit" value = "submit" -->
                                                                <!-- data-toggle="tooltip" title="Delete Booking" -->
                                                                <!-- onclick = "return confirm('Do You Really Want to Delete?')" -->
                                                                <!-- class = "btn btn-md btn-circle"> -->
                                                                <!-- <i class = "fa fa-trash"></i></button> -->
                                                        <!-- </form> -->
                                                    <!-- </div> -->
                                                    <div class = "col-md-12 col-12 m-1">
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#UpdateModal{{ $booking->id }}">Update</button>
                                                    </div>
                                                    <div class = "col-md-12 col-12 m-1">
                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $booking->id }}">Upload PDF</button>
                                                    </div>
                                                    <div class = "col-md-12 col-12 m-1">
                                                        <a href="{{ route('admin.newspaper_mail', $booking->id) }}">
                                                        <button class="btn btn-info" onclick = "return confirm('Do You Really Want to Sent Mail To NewsPaper?')">Mail To NewsPaper</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Modal -->
                <div class="modal fade" id="UpdateModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Update Booking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            {{ method_field('PUT') }} 
                              <input type="hidden" name="booking_id" value="{{ $booking->id }}"> 
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Add News Paper</label
                                    >
                                 <div class="col-sm-9">
                                    <select class="form-control" name="news_paper_id" >
                                        <option disabled selected>Select News Paper</option>
                                        @foreach($papers as $paper)
                                        <option value="{{$paper->id}}" @if($booking->news_paper_id == $paper->id) selected @endif>{{$paper->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Add Price</label
                                    >
                                 <div class="col-sm-9"> 
                                    <input type="number" class="form-control" name="price" value="{{$booking->price}}" />
                                 </div>
                              </div>
                              
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">Currency</label>
                                 <div class="col-sm-9">
                                    <input type="text" class="form-control" name="currency_symbol" value="{{$booking->currency_symbol == Null || $booking->currency_symbol == "" ? "€" : $booking->currency_symbol }}" />
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


                                            <!-- Modal -->
                <div class="modal fade" id="exampleModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add Proof Reading Pdf</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('admin.proof_pdf') }}" method="POST" enctype="multipart/form-data" >
                              @csrf  
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Add Pdf</label
                                    >
                                 <div class="col-sm-9">
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input
                                       type="file"
                                       class="form-control"
                                       name="pdf"
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

@section('script')
    <!-- Add your Bootstrap JS or any other scripts here -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('body').on('click', '#acceptBookingModal', function() {
                var bookingURL = $(this).data('url');
                $.get(bookingURL, function(data) {
                    $('#acceptBookingModal').modal('showBookingById');
                });
            });
        });
    </script>
@endsection

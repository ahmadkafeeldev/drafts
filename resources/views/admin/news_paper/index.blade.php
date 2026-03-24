@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>News Papers List</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">News Papers List</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">News Papers Data</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>News Paper</th>                        
                                    <th>Email</th> 
                                    <th>Borough</th>                        
                                    <th>Booking Deadline</th>                
                                    <th>Publish Date</th> 
                                    <th>News Group</th>
                                    <th>Area</th>
                                    <th>Rate</th>
                                    <th>Created At</th>    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>News Paper</th>              
                                    <th>Email</th> 
                                    <th>Borough</th>                        
                                    <th>Booking Deadline</th>                
                                    <th>Publish Date</th> 
                                    <th>News Group</th>
                                    <th>Area</th>
                                    <th>Rate</th>
                                    <th>Created At</th>     
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($news_papers as $key=>$news_paper)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $news_paper->name }}</td>
                                        <td>{{ $news_paper->email }}</td>
                                        <td>{{ $news_paper->borough }}</td>
                                        <td>{{ $news_paper->booking_deadline }}</td>
                                        <td>{{ $news_paper->publish_date }}</td>
                                        <td>{{ $news_paper->news_group }}</td>
                                        <td>{{ $news_paper->area }}</td>
                                        <td>{{ $news_paper->rate }}</td>
                                        <td>{{ $news_paper->created_at }}</td>
                                        <td>
                                            <div class="row pl-3">
                                                <div class="col-md-2">
                                                    <form action="{{ route('admin.news_papers.destroy', $news_paper->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" name="submit" value="submit" data-toggle="tooltip" title="Delete News Paper" onclick="return confirm('Do You Really Want to Delete?')" class="btn btn-sm btn-circle btn-outline-danger" style="margin-left: -10px;"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-md-2 ml-2">
                                                    <!-- Edit Button -->
                                                    <!--<button type="button" name="edit" data-toggle="modal" data-target="#editNewsPaperModal{{$news_paper->id}}" title="Edit News Paper" class="btn btn-sm btn-circle btn-outline-primary ml-1" style="margin-left: -10px;"><i class="fa fa-pen"></i></button>-->
                                                
                                                
                                                <!-- Edit Button -->
                                                <button type="button" name="edit" data-toggle="modal" data-target="#editNewsPaperModal{{ $news_paper->id }}" title="Edit News Paper" class="btn btn-sm btn-circle btn-outline-primary ml-1" style="margin-left: -10px;">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                                </div>

                                            </div>
                                        </td>

                                    </tr>
                                    
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editNewsPaperModal{{ $news_paper->id }}" tabindex="-1" role="dialog" aria-labelledby="editNewsPaperModalLabel{{ $news_paper->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-primary" id="editNewsPaperModalLabel{{ $news_paper->id }}">Edit News Paper</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.news_papers.update', $news_paper->id) }}" method="POST">
                                                        @csrf  
                                                        @method('PUT')
                                                        <div class="form-group row">
                                                            <label for="name{{ $news_paper->id }}" class="col-sm-3 col-form-label">News Paper</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="name" id="name{{ $news_paper->id }}" value="{{ $news_paper->name }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="email{{ $news_paper->id }}" class="col-sm-3 col-form-label">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="email" class="form-control" name="email" id="email{{ $news_paper->id }}" value="{{ $news_paper->email }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="borough{{ $news_paper->id }}" class="col-sm-3 col-form-label">Borough</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="borough" id="borough{{ $news_paper->id }}" required>
                                                                    <option disabled>Select Borough</option>
                                                                    @foreach($boroughs as $borough)
                                                                        <option value="{{ $borough->id }}" {{ $news_paper->borough == $borough->id ? 'selected' : '' }}>
                                                                            {{ $borough->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="news_group{{ $news_paper->id }}" class="col-sm-3 col-form-label">News Group</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="news_group" id="news_group{{ $news_paper->id }}" required>
                                                                    <option disabled>Select News Group</option>
                                                                    @foreach($groups as $group)
                                                                        <option value="{{ $group->id }}" {{ $news_paper->news_group == $group->id ? 'selected' : '' }}>
                                                                            {{ $group->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="booking_deadline{{ $news_paper->id }}" class="col-sm-3 col-form-label">Booking Deadline</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="booking_deadline" id="booking_deadline{{ $news_paper->id }}" value="{{ $news_paper->booking_deadline }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="publish_date{{ $news_paper->id }}" class="col-sm-3 col-form-label">Publish Date</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="publish_date" id="publish_date{{ $news_paper->id }}" value="{{ $news_paper->publish_date }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="rate{{ $news_paper->id }}" class="col-sm-3 col-form-label">Rate</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="rate" id="rate{{ $news_paper->id }}" value="{{ $news_paper->rate }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="area{{ $news_paper->id }}" class="col-sm-3 col-form-label">Area</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="area" id="area{{ $news_paper->id }}" required>
                                                                    <option disabled>Select Area</option>
                                                                    @foreach($area as $a)
                                                                        <option value="{{ $a->id }}" {{ $news_paper->area == $a->id ? 'selected' : '' }}>
                                                                            {{ $a->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
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
                
                <!-- ADD Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Add New News Paper</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                            <form action="{{ route('admin.news_papers.store') }}" method="POST" enctype="multipart/form-data" >
                              @csrf  
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 News Paper</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="name"
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
                                       type="text"
                                       class="form-control"
                                       name="email"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Borough</label
                                    >
                                 <div class="col-sm-9">
                                    <select class="form-control" name="borough" required>
                                        <option disabled selected>*Select Borough*</option>
                                        @foreach($boroughs as $borough)
                                        <option value="{{$borough->id}}">{{$borough->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_number" class="col-sm-3 col-form-label">
                                 News Group</label
                                    >
                                 <div class="col-sm-9">
                                    <select class="form-control" name="news_group" required>
                                        <option disabled selected>*Select News Group*</option>
                                        @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="text" class="form-control" name="news_group" required /> -->
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Booking Deadline</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="booking_deadline"
                                       required
                                       />
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Publish Date</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="publish_date"
                                       required
                                       />
                                 </div>
                              </div>
                              
                              <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Rate</label
                                    >
                                 <div class="col-sm-9">
                                    <input
                                       type="text"
                                       class="form-control"
                                       name="rate"
                                       required
                                       />
                                 </div>
                              </div>
                               <div class="form-group row">
                                 <label for="p_number" min="0" step="00" class="col-sm-3 col-form-label">
                                 Area</label
                                    >
                                 <div class="col-sm-9">
                                    <select class="form-control" name="area" required>
                                        <option disabled selected>*Select Area*</option>
                                        @foreach($area as $a)
                                            <option value="{{$a->id}}">{{$a->name}}</option>
                                        @endforeach
                                    </select>
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
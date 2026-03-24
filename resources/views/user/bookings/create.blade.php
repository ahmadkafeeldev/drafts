@extends('layouts.user.app')
@section('title')
Account Details
@endsection

    
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    .highlight {
        background-color: yellow !important;
    }
      .sidebar ul {
        list-style-type: none;
      }
      a {
        text-decoration: none;
      }
      .sidebar ul > li {
        border-bottom: 2px solid #f3f3f3;
        color: #333;
        font-size: 14px;
        font-weight: 500;
        line-height: normal;
        position: relative;
        padding: 0;
      }
      .sidebar ul > li {
        display: block;
        padding: 3px 0;
        margin-left: -40px;
      }
      .sidebar ul li a {
        line-height: 24px;

        font-size: 15px;
        line-height: 24px;

        color: #333;
        display: block;
        outline: none;
        padding: 10px 0;
        text-decoration: none;
        background: #fbfbfb;
        padding-left: 20px;
      }
      .menu-dashboard {
        border: 2px solid #e8ecec;
        border-radius: 8px;
      }
      .sidebar ul li a span {
        padding-right: 10px;
        vertical-align: middle;
        color: #babebe;
        width: 35px;
        font-size: 22px;
        line-height: 20px;
      }

      /*avatat styling*/
      #avatar-div {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border-style: solid;
  border-color: #ffd3d3;
  box-shadow: 0 0 8px 3px #B8B8B8;
  position: relative;
  margin: 10px auto;
}

#avatar-div img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
}

#avatar-div i {
  position: absolute;
  top: 5px;
  right: -7px;
  /* border: 1px solid; */
  border-radius: 50%;
  /* padding: 11px; */
  height: 30px;
  width: 30px;
  display: flex !important;
  align-items: center;
  justify-content: center;
  background-color: white;
  /* color: cornflowerblue; */
  color: #fa2964;
  box-shadow: 0 0 8px 3px #B8B8B8;
}
      
</style>
    
    
    
    <div class="row">
        <div class="col-md-12 ">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    </div>
    
    
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="login-form">
                <div class="py-3 text-center">
                    <h4>Create New Advertisement</h4>
                </div>
               
                     <!---------avatar end----------->
                    <form action="{{ route('user.bookings.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        
                         <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="booking_type">Traffic Order Type</label>
                                <select class="form-control" name="booking_type" id="booking_type" required>
                                    <option disabled selected>*Select Advertisement Type*</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="Permanent">Permanent</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="title">Title</label>
                                <select class="form-control select2" name="title" id="title" required>
                                    <option disabled selected>Select or Add New Title</option>
                                    <option value="new">Add New Notice</option>
                                    @foreach($existingTitles as $booking)
                                        <option value="{{ $booking->title }}" 
                                                data-news-paper-id="{{ $booking->news_paper_id }}"
                                                data-borough-id="{{ $booking->borough }}"
                                                data-area-id="{{ $booking->area }}"
                                                data-publish-date="{{ $booking->publish_date }}"
                                                data-booking-type="{{ $booking->booking_type }}"
                                                data-notice-type="{{ $booking->notice_type }}">
                                            {{ $booking->title }}
                                        </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        
                         <div class="row" id="new_notice_field" style="display: none;">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="new_notice_title">New Notice Title</label>
                                <input type="text" class="form-control" name="new_notice_title" id="new_notice_title" placeholder="Enter new notice title" />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="cname">Notice Type</label>
                                <select class="form-control" name="notice_type" required>
                                    <option disabled selected>*Select Notice Type*</option>
                                    <option value="Notice of Intent">Notice of Intent</option>
                                    <option value="Notice of Making">Notice of Making</option>
                                </select>
                            </div>
                        </div>
                        
                       
                    
                        <!-- London Gazette Field (Initially Hidden) -->
                        <div class="row" id="london_gazette_field" style="display: none;">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="london_gazette">Gazette</label>
                                <input type="text" class="form-control" name="london_gazette" value="London Gazette" readonly />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="cname">Area of Work(optional)</label>
                                <select class="form-control" name="area">
                                    <option disabled selected>Select Area of Work</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                    
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="cname">Borough</label>
                                <select class="form-control" name="borough" required>
                                    <option disabled selected>*Select Borough*</option>
                                    @foreach($boroughs as $borough)
                                        <option value="{{ $borough->id }}">{{ $borough->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="cname">News Paper(optional)</label>
                                <select class="form-control" name="news_paper_id">
                                    <option disabled selected>Select News Paper</option>
                                    @foreach($papers as $paper)
                                        <option value="{{ $paper->id }}">{{ $paper->name }} - Booking Deadline:{{ $paper->booking_deadline }} - Publish at:{{ $paper->publish_date }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="publish_date">Publication Date</label>
                                <input type="date" class="form-control" name="publish_date" required />
                            </div>
                        </div>
                        
                        
                    
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="document">Attach Word Document</label>
                                <input type="file" class="form-control" name="document" accept=".doc,.docx,.odt" required />
                            </div>
                        </div>
                    
                    
                        <div class="row justify-content-center pb-4">
                            <button type="submit" class="w-100 btn btn-primary">Submit</button>
                        </div>
                    </form>


        </div>
      </div>
    </div>
    
    
    
<script>

document.addEventListener('DOMContentLoaded', function() {
    loadFormValues();

    document.getElementById('booking_type').addEventListener('change', function() {
        const selectedBookingType = this.value;
        const titleSelect = document.getElementById('title');
        const londonGazetteField = document.getElementById('london_gazette_field');

        // Update placeholder based on booking type
        if (selectedBookingType === 'Permanent') {
            titleSelect.placeholder = 'Please select the title for Permanent';
            londonGazetteField.style.display = 'block'; // Show the London Gazette field
        } else if (selectedBookingType === 'Temporary') {
            titleSelect.placeholder = 'Please select the title for Temporary';
            londonGazetteField.style.display = 'none'; // Hide the London Gazette field
        } else {
            titleSelect.placeholder = 'Please select the title';
            londonGazetteField.style.display = 'none'; // Hide the London Gazette field
        }

        // Show or hide titles based on selected booking type
        Array.from(titleSelect.options).forEach(option => {
            if (option.value === "new" || option.getAttribute('data-booking-type') === selectedBookingType || selectedBookingType === '') {
                option.style.display = 'block'; // Show matching titles or 'Add New Notice'
            } else {
                option.style.display = 'none'; // Hide non-matching titles
            }
        });

        // Optional: Reset the title selection
        titleSelect.value = '';
    });

    document.getElementById('title').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const newNoticeField = document.getElementById('new_notice_field');
        const noticeTypeSelect = document.querySelector('select[name="notice_type"]');

        if (selectedOption) {
            if (selectedOption.value === "new") {
                newNoticeField.style.display = 'block';
                // Show only "Notice of Intent" and set it as the default
                populateNoticeTypeOptions('Notice of Intent');
                noticeTypeSelect.value = 'Notice of Intent';
            } else {
                newNoticeField.style.display = 'none';
                populateFieldsFromSelectedOption(selectedOption);
                const noticeType = selectedOption.getAttribute('data-notice-type');
                noticeTypeSelect.value = (noticeType === 'Notice of Intent') ? 'Notice of Making' : 'Notice of Intent';
                populateNoticeTypeOptions();
            }
        }

        saveFormValues();
    });

    function populateNoticeTypeOptions(defaultNoticeType) {
        const noticeTypeSelect = document.querySelector('select[name="notice_type"]');
        // Clear all existing options
        noticeTypeSelect.innerHTML = '';

        // Conditionally add options based on the defaultNoticeType
        if (defaultNoticeType === 'Notice of Intent') {
            const option = document.createElement('option');
            option.value = 'Notice of Intent';
            option.text = 'Notice of Intent';
            noticeTypeSelect.add(option);
        } else if (defaultNoticeType === 'Notice of Making') {
            const option = document.createElement('option');
            option.value = 'Notice of Making';
            option.text = 'Notice of Making';
            noticeTypeSelect.add(option);
        } else {
            const option1 = document.createElement('option');
            option1.value = 'Notice of Intent';
            option1.text = 'Notice of Intent';
            noticeTypeSelect.add(option1);

            const option2 = document.createElement('option');
            option2.value = 'Notice of Making';
            option2.text = 'Notice of Making';
            noticeTypeSelect.add(option2);
        }
    }

    function populateFieldsFromSelectedOption(option) {
        document.querySelector('select[name="news_paper_id"]').value = option.getAttribute('data-news-paper-id') || '';
        document.querySelector('select[name="borough"]').value = option.getAttribute('data-borough-id') || '';
        document.querySelector('select[name="area"]').value = option.getAttribute('data-area-id') || '';
        document.querySelector('input[name="publish_date"]').value = option.getAttribute('data-publish-date') || '';
        document.getElementById('booking_type').value = option.getAttribute('data-booking-type') || '';
        document.querySelector('select[name="notice_type"]').value = option.getAttribute('data-notice-type') || '';
    }

    function clearAllFields() {
        document.querySelector('select[name="news_paper_id"]').value = '';
        document.querySelector('select[name="borough"]').value = '';
        document.querySelector('select[name="area"]').value = '';
        document.querySelector('input[name="publish_date"]').value = '';
        document.getElementById('booking_type').value = '';
        document.querySelector('select[name="notice_type"]').value = '';
        document.getElementById('london_gazette_field').style.display = 'none';
    }

    function setPlaceholders() {
        document.querySelector('select[name="news_paper_id"]').placeholder = 'Select Newspaper';
        document.querySelector('select[name="borough"]').placeholder = 'Select Borough';
        document.querySelector('select[name="area"]').placeholder = 'Select Area';
        document.querySelector('input[name="publish_date"]').placeholder = 'Enter Publish Date';
        document.getElementById('booking_type').placeholder = 'Select Booking Type';
        document.querySelector('select[name="notice_type"]').placeholder = 'Select Notice Type';
    }

    function loadFormValues() {
        const storedValues = JSON.parse(localStorage.getItem('formValues'));
        if (storedValues) {
            document.querySelector('select[name="news_paper_id"]').value = storedValues.news_paper_id || '';
            document.querySelector('select[name="borough"]').value = storedValues.borough || '';
            document.querySelector('select[name="area"]').value = storedValues.area || '';
            document.querySelector('input[name="publish_date"]').value = storedValues.publish_date || '';
            document.getElementById('booking_type').value = storedValues.booking_type || '';
            document.querySelector('select[name="notice_type"]').value = storedValues.notice_type || '';
            document.getElementById('title').value = storedValues.title || '';
            document.getElementById('london_gazette_field').style.display = (storedValues.booking_type === 'Permanent') ? 'block' : 'none';
            document.getElementById('new_notice_field').style.display = (storedValues.title === 'new') ? 'block' : 'none';
        }

        setTimeout(function() {
            localStorage.removeItem('formValues');
        }, 10000);
    }

    function saveFormValues() {
        const formValues = {
            news_paper_id: document.querySelector('select[name="news_paper_id"]').value,
            borough: document.querySelector('select[name="borough"]').value,
            area: document.querySelector('select[name="area"]').value,
            publish_date: document.querySelector('input[name="publish_date"]').value,
            booking_type: document.getElementById('booking_type').value,
            notice_type: document.querySelector('select[name="notice_type"]').value,
            title: document.getElementById('title').value
        };
        localStorage.setItem('formValues', JSON.stringify(formValues));
    }

    document.querySelector('form').addEventListener('submit', function() {
        saveFormValues();
    });
});



</script>

@endsection


@section('script')

@endsection


@extends('layouts.drafts.app')

@section('title', 'Public Notice')

@section('styles')
<style>
    .public-notice-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border: 1px solid #ddd;
    }
    .header-section {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #333;
        padding-bottom: 20px;
    }
    .form-section {
        margin-bottom: 25px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        background: #f9f9f9;
    }
    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }
    .form-label {
        min-width: 200px;
        font-weight: bold;
        margin-right: 10px;
    }
    .form-field {
        flex: 1;
        min-width: 150px;
    }
    .dropdown-field, .text-field {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .radio-group {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .radio-option {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .static-text {
        font-style: italic;
        color: #666;
    }
    .section-title {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }
    .contact-section {
        background: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        margin-top: 20px;
    }
    .conditional-section {
        display: none;
    }
    /* Preview Modal Styles */
    .preview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
        z-index: 1000;
        overflow: auto;
    }
    .preview-content {
        background-color: white;
        margin: 2% auto;
        padding: 20px;
        width: 80%;
        max-width: 800px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .preview-title {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .close-preview {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
    }
    .preview-body {
        max-height: 70vh;
        overflow-y: auto;
    }
    .preview-template {
        background: white;
        padding: 20px;
        border: 1px solid #ddd;
        font-family: Arial, sans-serif;
    }
    /* Multiple work places styles */
    .work-place-container {
        margin-bottom: 2px;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        background: #f8f9fa;
    }
    .the-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.the-wrapper .prefix,
.the-wrapper .suffix {
    font-weight: bold;
    white-space: nowrap;
}

    .work-place-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .work-place-title {
        font-weight: bold;
        color: #333;
    }
    .remove-work-place {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }
    .add-work-place {
        /*background: #28a745;*/
        color: black;
        border: none;
       /*font-weight: bold;*/
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        /*margin-top: 2px;*/
    }
</style>
@endsection

@php
    $specificOrderTypeDrafts14_1            = $drafts->where('order_type', '14 (1) – Full or Partial Road Closure');
    $emergencyWorkDrafts                    = $drafts->where('order_type', '14 (2) – Emergency Work Order');
    $specificOrderTypeDrafts16_a            = $drafts->where('order_type', '16 (A) – Special Events');
    $specificOrderTypeDrafts_section_23     = $drafts->where('order_type', 'Section 6');

    $section_6                              = $drafts->where('order_type', 'Section 6');
    $section_15_2                           = $drafts->where('order_type', '15(2)-Pedestrian');
    $Banned_Turn_Order                      = $drafts->where('order_type', 'Banned Turn Order');
    $Prescribed_Route_Order                 = $drafts->where('order_type', 'Prescribed Route Order');
    $Bus_Priority_Orders                    = $drafts->where('order_type', 'Bus Priority Orders');
    $Clearway_Orders                        = $drafts->where('order_type', 'Clearway Orders');
    $Cycle_Lane_Order                       = $drafts->where('order_type', 'Cycle Lane Order');
    $Cycle_Track_Notices                    = $drafts->where('order_type', 'Cycle Track Notices');
    $Speed_Limit_83_84                      = $drafts->where('order_type', 'Speed Limit 83 & 84');
    $Variation_Orders                       = $drafts->where('order_type', 'Variation Orders');
    $Consolidated_Orders                    = $drafts->where('order_type', 'Consolidated Orders');
    $Parking_Control_Orders                 = $drafts->where('order_type', 'Parking Control Orders');
    $Priority_Traffic_Lane                  = $drafts->where('order_type', 'Priority Traffic Lane');
    $Section_9_Experimental                 = $drafts->where('order_type', 'Section 9 Experimental');
    $Section_9_6                            = $drafts->where('order_type', 'Section 9-6');
    $Section_9_83                           = $drafts->where('order_type', 'Section 9-83/84');
    $Revocation_Order                       = $drafts->where('order_type', 'Revocation Order');
    $Modification_Order                     = $drafts->where('order_type', 'Modification Order');
@endphp

@section('content')

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

<!-- Preview Modal -->
<div id="previewModal" class="preview-modal">
    <div class="preview-content">
        <div class="preview-header">
            <div class="preview-title"></div>
            <button class="close-preview">&times;</button>
        </div>
        <div class="preview-body">
            <div id="previewTemplate" class="preview-template">
                <!-- Preview content will be inserted here -->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if(session()->has('message'))
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
          <span class="font-medium">Success alert!</span> {{ session()->get('message') }}.
        </div>
        @endif
        @if(session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
              <span class="font-medium">Error alert!</span> {{ session()->get('error') }}.
            </div>
        @endif
    </div>
</div>

<div class="container mx-auto p-4 py-10 sm:p-10">
    <!-- Form Selection Section -->
    <div class="mb-8 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Form Selection</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Traffic Order Type Dropdown -->
            <div>
                <label for="booking_type" class="block text-gray-700 font-semibold mb-2">Traffic Order Type</label>
                <select name="booking_type" id="booking_type" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option disabled selected>*Select Traffic Order Type*</option>
                    <option value="temporary">Temporary</option>
                    <option value="permanent">Permanent</option>
                    <option value="experimental">Experimental</option>
                </select>
            </div>

            <!-- Notice Type Dropdown -->
            <div>
                <label for="notice_type" class="block text-gray-700 font-semibold mb-2">Select Type of Notice</label>
                <select name="notice_type" id="notice_type" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option disabled selected>*Select Type of Notice*</option>
                    <option>Notice of Intent</option>
                    <option>Notice of Making</option>
                    <option>Trafic Order</option>
                </select>
            </div>

            <!-- Relevant Order Dropdown -->
            <div>
                <label for="order_type" class="block text-gray-700 font-semibold mb-2">Select Relevant Order</label>
                <select name="relevant_order" id="order_type" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option disabled selected>*Select Relevant Order*</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Public Notice Form -->
    <div class="public-notice-container">
        <!-- Header Section -->
        <div class="header-section">
            <!--<h1 class="text-3xl font-bold mb-2">LOGO</h1>-->
            <h2 class="text-xl font-bold">TRANSPORT FOR LONDON</h2>
            <h3 class="text-lg font-semibold">Public Notice:</h3>
            <h4 class="text-md font-bold">ROAD TRAFFIC REGULATION ACT 1984</h4>
        </div>

        <form action="{{ route('user.store_draft') }}" method="post" enctype="multipart/form-data" id="publicNoticeForm">
            @csrf
            
            <!-- Hidden fields for form selection -->
            <input type="hidden" id="booking_type_hidden" name="booking_type">
            <input type="hidden" id="notice_type_hidden" name="notice_type">
            <input type="hidden" id="relevant_order_hidden" name="relevant_order">

            <!-- ========== ORIGINAL FORM FIELDS ========== -->

            <!-- Plan and Permit Section -->
            <div id="plan_permit_section" class="conditional-section form-section">
                <div class="section-title">Additional Requirements</div>
                
                <!-- Plan Upload Radio Buttons -->
                <div class="form-row" id="have_plan">
                    <span class="form-label">Do You Have Plan?</span>
                    <div class="form-field">
                        <div class="radio-group">
                            <div class="radio-option">
                                <input id="yes_uploaded_your_plan" type="radio" value="yes" name="plan" class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 h-4 w-4 rounded-full">
                                <label for="yes_uploaded_your_plan" class="ms-2 text-sm font-medium text-gray-900">Yes</label>
                            </div>
                            <div class="radio-option">
                                <input id="no_uploaded_your_plan" type="radio" value="no" name="plan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600" checked>
                                <label for="no_uploaded_your_plan" class="ms-2 text-sm font-medium text-gray-900">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden field for file upload -->
                <div id="state-container" class="conditional-section form-row">
                    <span class="form-label">Upload Plan Document</span>
                    <div class="form-field">
                        <input type="file" name="plan_doc" id="no_uploaded_plan" class="text-field">
                    </div>
                </div>

                <!-- Work Permit Radio Buttons -->
                <div class="form-row">
                    <span class="form-label">Have you applied and got approval for work permit?</span>
                    <div class="form-field">
                        <div class="radio-group">
                            <div class="radio-option">
                                <input id="yes_work_permit" type="radio" value="yes" name="work_permit" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="yes_work_permit" class="ms-2 text-sm font-medium text-gray-900">Yes</label>
                            </div>
                            <div class="radio-option">
                                <input id="no_work_permit" type="radio" value="no" name="work_permit" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600" checked>
                                <label for="no_work_permit" class="ms-2 text-sm font-medium text-gray-900">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden field for permit number -->
                <div id="state-container-2" class="conditional-section form-row">
                    <span class="form-label">Permit Number</span>
                    <div class="form-field">
                        <input type="text" id="permit_number" name="permit_number" placeholder="Add your Permit Number" class="text-field">
                    </div>
                </div>
            </div>

            <!-- Create Your Order Section -->
            <div id="create_order_section" class="conditional-section form-section">
                <div class="section-title">
                
                  <div class="form-row">
                    <span class="form-label">Create Your Order</span>
                    <div class="form-field">
                        <div class="radio-group">
                            <div class="radio-option">
                                <input id="transport_london" type="radio" value="yes" name="work_permits" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="transport_london" class="ms-2 text-sm font-medium text-gray-900">Transport For London</label>
                            </div>
                            <div class="radio-option">
                                <input id="Borough" type="radio" value="no" name="work_permits" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600" checked>
                                <label for="Borough" class="ms-2 text-sm font-medium text-gray-900">Borough</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                </div>
                
                
                <div class="form-row">
                    <span class="form-label">Name of the Authority doing the work?</span>
                    <div class="form-field">
                        <select id="authourities" name="authourities" class="dropdown-field">
                            <option disabled selected>--- Select Authority Type ---</option>
                            <option value="Transport for London">Transport for London</option>
                            <option value="Highways England">Highways England</option>
                            <option value="Borough Authority">Borough Authority</option>
                        </select>
                    </div>
                </div>
                
               
                
                <!-- Multiple Work Places Section -->
                <div class="form-row">
                    <span class="form-label">Road where work will take place</span>
                    <div class="form-field">
                        <div id="work_places_container">
                            <!-- First work place field -->
                           <div class="work-place-container" data-index="0">
    <div class="work-place-header">
        <div class="work-place-title">Road Location #1</div>
        <button type="button" class="remove-work-place" onclick="removeWorkPlace(0)" style="display: none;">Remove</button>
    </div>

    <div class="the-wrapper">
        <span class="prefix">THE A</span>
        <input type="text" name="work_places[0]" placeholder="Number" class="text-field">
        
        <span class="suffix">GLA ROAD</span>
    </div>
</div>

                        </div>
                        <button type="button" id="add_work_place" class="add-work-place">+ Road Location</button>
                    </div>
                </div>
                
                  <div class="form-row">
                    <!--<span class="form-label"></span>-->
                    <div class="form-field">
                        <select id="title_1" name="title_1" class="dropdown-field">
                            <option disabled selected> Please Select </option>
                            <option value="Full closure"></option>
                            <option value="TEMPORARY PROHIBITION OF">TEMPORARY PROHIBITION OF</option>
                            <option value="PERMANENT PROHIBITION OF">PERMANENT PROHIBITION OF</option>
                        </select>
                    </div>
                    
                        <div class="form-field">
                        <select id="title_2" name="title_2" class="dropdown-field">
                            <option disabled selected> Please Select </option>
                            <option value="Full closure"></option>
                            <option value="TRAFIC">TRAFIC</option>
                            <option value="TRAFIC AND STOPING">TRAFIC AND STOPING</option>
                             <option value="STOPING">STOPING</option>
                              <option value="BANNED TURN">BANNED TURN</option>
                               <option value="SPEED LIMIT">SPEED LIMIT</option>
                        </select>
                    </div>
                    
                    
                  
                    <div class="form-field">
                          <!--<span class="form-label" for="order_year">Order year</span>-->
                        <input type="text" id="a_street" name="order_year" placeholder="Order Year" class="text-field">
                    </div>
               
                    
                </div>
                
                <div class="form-row">
                    <span class="form-label">Type of Closure</span>
                    <div class="form-field">
                        <select id="closure_type" name="closure_type" class="dropdown-field">
                            <option disabled selected>--- Select Type of work ---</option>
                            <option value="Full closure">Full closure</option>
                            <option value="Directional Closure">Directional Closure</option>
                            <option value="Contra Flow">Contra Flow</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">What is the purpose of the work?</span>
                    <div class="form-field">
                        <input type="text" id="work_purpose" name="work_purpose" class="dropdown-field">
                        <!--    <option disabled selected>--- Select purpose of work ---</option>-->
                        <!--    <option value="Repairs">Repairs</option>-->
                        <!--    <option value="Maintenance">Maintenance</option>-->
                        <!--    <option value="Resurfacing">Resurfacing</option>-->
                        <!--    <option value="Litter Clearing">Litter Clearing and Cleaning</option>-->
                        <!--    <option value="Water">Water</option>-->
                        <!--    <option value="Gas">Gas</option>-->
                        <!--    <option value="Gullies">Gullies</option>-->
                        <!--    <option value="Because of the likelihood of danger to the public or of serious damage to the road">Because of the likelihood of danger to the public or of serious damage to the road</option>-->
                        <!--    <option value="To enable litter clearing and cleaning to be discharged">To enable litter clearing and cleaning to be discharged</option>-->
                        <!--    <option value="To enable resurfacing">To enable resurfacing</option>-->
                        <!--    <option value="Others">Others</option>-->
                        <!--</select>-->
                    </div>
                </div>

                        <div class="form-row">
                    <span class="form-label">Road Address</span>
                    <div class="form-field">
                        <input type="text" id="location" name="location" placeholder="Enter Location." class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Restriction Type</span>
                    <div class="form-field">
                        <select id="effect_orders" name="effect_orders" class="dropdown-field">
                            <option disabled selected>--- Select Effect Order Type ---</option>
                            <option value="Restrict">Restrict</option>
                            <option value="Prohibit">Prohibit</option>
                            <option value="Suspend">Suspend</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Prohibit of Traffic</span>
                    <div class="form-field">
                        <select id="prohibition_traffic" name="prohibition_traffic" class="dropdown-field">
                            <option disabled selected>--- Select the prohibit of traffic ---</option>
                            <option value="any vehicle proceeding on the workRoad from entering or exiting between its junctions with A or B">any vehicle proceeding on the workRoad from entering or exiting between its junctions with A or B</option>
                            <option value="any vehicle proceeding on the workRoad from stopping between its junctions with A or B">any vehicle proceeding on the workRoad from stopping between its junctions with A or B</option>
                            <option value="any vehicle proceeding on the workRoad from turning right at its junction with A Street A or Street B">any vehicle proceeding on the workRoad from turning right at its junction with A Street A or Street B</option>
                            <option value="any vehicle proceeding on the workRoad must travel 'ahead only' at its junction with STreet A">any vehicle proceeding on the workRoad must travel 'ahead only' at its junction with STreet A</option>
                            <option value="any vehicle proceeding on the workRoad from entering, proceeding, exiting or stopping between its junction with Street A or Street B">any vehicle proceeding on the workRoad from entering, proceeding, exiting or stopping between its junction with Street A or Street B</option>
                        </select>
                    </div>
                </div>

                  <div class="form-row">
                    <span class="form-label">Address Street A </span>
                    <div class="form-field">
                        <input type="text" name="street_a" id="place_at" placeholder="Road" class="text-field">
                    </div>
                </div>
                <div class="form-row">
                    <span class="form-label">Address Street B</span>
                    <div class="form-field">
                        <input type="text" name="street_b" id="place_at" placeholder="Road" class="text-field">
                    </div>
                </div>
             
               

                <div class="form-row">
                    <span class="form-label">Order Under Section</span>
                    <div class="form-field">
                        <select id="order_under_section" name="order_under_section" class="dropdown-field">
                            <option disabled selected>--- Select Order Under Section ---</option>
                            @foreach ($drafts as $data)
                                @if($data->booking_type == "Temporary")
                                    <option value="{{ $data->order_type }}">{{ $data->order_type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">With/Without suspension</span>
                    <div class="form-field">
                        <select id="temporary_order_type" name="vehicle_form" class="dropdown-field">
                            <option disabled selected>--- Select Type ---</option>
                            <option value="With bays suspension">With bays suspension</option>
                            <option value="Without bays suspension">Without bays suspension</option>
                        </select>
                    </div>
                </div>
                
                         
                
                                <div class="form-row">
                    <span class="form-label">Local Access</span>
                    <div class="form-field">
                        <input type="text" id="local_access" name="local_access" placeholder="" class="text-field">
                    </div>
                </div>
                
                <div class="form-row">
                    <span class="form-label">Diversion plans/ Alternative Road</span>
                    <div class="form-field">
                        <input type="text" id="diversion_plans" name="diversion_plans" placeholder="Traffic Signs [via---]." class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Start time</span>
                    <div class="form-field">
                        <input type="time" id="start_time" name="start_time" class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Start Date</span>
                    <div class="form-field">
                        <input type="date" id="from_date" name="from_date" class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">End time</span>
                    <div class="form-field">
                        <input type="time" id="end_time" name="end_time" class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">End Date</span>
                    <div class="form-field">
                        <input type="date" id="to_date" name="to_date" class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Signature</span>
                    <div class="form-field">
                        <input name="signature" type="file" placeholder="signature" class="text-field">
                    </div>
                </div>

                  <div class="form-row">
                    <span class="form-label">Appropriate Person</span>
                    <div class="form-field">
                        <input type="text" name="appropriate_person" placeholder="Person Name" class="text-field">
                    </div>
                </div>
                  
                <div class="form-row">
                    <span class="form-label">Person Title</span>
                    <div class="form-field">
                        <input type="text" name="person_title" placeholder="Person Title" class="text-field">
                    </div>
                </div>

                <div class="form-row">
                    <span class="form-label">Palestra Address</span>
                    <div class="form-field">
                        <input type="text" name="palestra_address" placeholder="Palestra, 197 Blackfriars Road, London, SE1 8NJ" class="text-field">
                    </div>
                </div>
            </div>

            <!-- Section 6 Form -->
            <div id="section_6_form" class="conditional-section form-section">
                <!-- Section 6 form fields remain the same -->
                <!-- ... (your existing section 6 form content) ... -->
            </div>

            <!-- Submit Buttons -->
            <div class="form-section" id="button_section" style="text-align: center; margin-top: 30px;">
                <button type="button" id="previewBtn" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-4">
                    Preview
                </button>
                <!--<button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">-->
                <!--    Save-->
                <!--</button>-->
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

@php
    $temporaryOrders = $drafts->filter(fn($draft) => $draft->booking_type == 'Temporary')->pluck('order_type');
    $permanentOrders = $drafts->filter(fn($draft) => $draft->booking_type == 'Permanent')->pluck('order_type');
@endphp

@endsection
@section('scripts')
<script>
    // Pass data from Blade to JavaScript
    const temporaryOrders = @json($temporaryOrders);
    const permanentOrders = @json($permanentOrders);

    let workPlaceCounter = 1;

    // Function to add new work place field
    function addWorkPlace() {
        const container = document.getElementById('work_places_container');
        const newIndex = workPlaceCounter;
        
        const workPlaceDiv = document.createElement('div');
        workPlaceDiv.className = 'work-place-container';
        workPlaceDiv.setAttribute('data-index', newIndex);
        
        workPlaceDiv.innerHTML = `
            <div class="work-place-header">
                <div class="work-place-title">Road Location #${newIndex + 1}</div>
                <button type="button" class="remove-work-place" onclick="removeWorkPlace(${newIndex})">Remove</button>
            </div>
            <input type="text" name="work_places[${newIndex}]" placeholder="A10 GLA Road" class="text-field">
        `;
        
        container.appendChild(workPlaceDiv);
        workPlaceCounter++;
        
        // Show remove buttons on all fields if there are more than one
        updateRemoveButtons();
    }

    // Function to remove work place field
    function removeWorkPlace(index) {
        const container = document.getElementById('work_places_container');
        const elementToRemove = container.querySelector(`[data-index="${index}"]`);
        
        if (elementToRemove) {
            container.removeChild(elementToRemove);
            updateRemoveButtons();
        }
    }

    // Function to update remove buttons visibility
    function updateRemoveButtons() {
        const containers = document.querySelectorAll('.work-place-container');
        const removeButtons = document.querySelectorAll('.remove-work-place');
        
        if (containers.length > 1) {
            removeButtons.forEach(button => button.style.display = 'block');
        } else {
            removeButtons.forEach(button => button.style.display = 'none');
        }
    }

    // Function to get all work place values
    function getWorkPlaces() {
        const workPlaces = [];
        const inputs = document.querySelectorAll('input[name^="work_places"]');
        
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                workPlaces.push(input.value.trim());
            }
        });
        
        return workPlaces;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bookingTypeDropdown = document.getElementById('booking_type');
        const orderTypeDropdown = document.getElementById('order_type');
        const noticeTypeDropdown = document.getElementById('notice_type');
        const addWorkPlaceBtn = document.getElementById('add_work_place');
        
        // Conditional sections
        const planPermitSection = document.getElementById('plan_permit_section');
         const havePlan = document.getElementById('have_plan');
        const createOrderSection = document.getElementById('create_order_section');
        const section6Form = document.getElementById('section_6_form');
        
        // Radio buttons and their containers
        const yesUploadedPlan = document.getElementById('yes_uploaded_your_plan');
        const noUploadedPlan = document.getElementById('no_uploaded_your_plan');
        const yesWorkPermit = document.getElementById('yes_work_permit');
        const noWorkPermit = document.getElementById('no_work_permit');
        const stateContainer = document.getElementById('state-container');
        const stateContainer2 = document.getElementById('state-container-2');
        const buttonSection = document.getElementById('button_section');

        // Radio buttons for Transport for London vs Borough
        const transportLondonRadio = document.getElementById('transport_london');
        const boroughRadio = document.getElementById('Borough');

        // Authorities dropdown
        const authoritiesDropdown = document.getElementById('authourities');

        // Preview elements
        const previewModal = document.getElementById('previewModal');
        const previewTemplate = document.getElementById('previewTemplate');
        const previewBtn = document.getElementById('previewBtn');
        const closePreview = document.querySelector('.close-preview');

        // Event listener for add work place button
        addWorkPlaceBtn.addEventListener('click', addWorkPlace);

        // Event listener for Transport for London vs Borough radio buttons
        transportLondonRadio.addEventListener('change', function() {
            if (this.checked) {
                updateAuthoritiesDropdown('transport');
            }
        });

        boroughRadio.addEventListener('change', function() {
            if (this.checked) {
                updateAuthoritiesDropdown('borough');
            }
        });

        // Function to update authorities dropdown based on radio selection
        function updateAuthoritiesDropdown(type) {
            authoritiesDropdown.innerHTML = '<option disabled selected>--- Select Authority Type ---</option>';
            
            if (type === 'transport') {
                const option = document.createElement('option');
                option.value = 'Transport for London';
                option.textContent = 'Transport for London';
                authoritiesDropdown.appendChild(option);
            } else if (type === 'borough') {
                const option1 = document.createElement('option');
                option1.value = 'Highways England';
                option1.textContent = 'Highways England';
                authoritiesDropdown.appendChild(option1);

                const option2 = document.createElement('option');
                option2.value = 'Borough Authority';
                option2.textContent = 'Borough Authority';
                authoritiesDropdown.appendChild(option2);
            }
        }

        // Event listener for booking type change
        bookingTypeDropdown.addEventListener('change', function() {
            const selectedBookingType = this.value;
            orderTypeDropdown.innerHTML = '<option disabled selected>*Select Relevant Order*</option>';

            let orders = [];
            if (selectedBookingType === 'temporary' || selectedBookingType === 'experimental') {
                orders = temporaryOrders;
            } else if (selectedBookingType === 'permanent') {
                orders = permanentOrders;
            }

            // Populate the order dropdown
            orders.forEach(function(order) {
                const option = document.createElement('option');
                option.value = order;
                option.textContent = order;
                orderTypeDropdown.appendChild(option);
            });

            checkAndShowSections();
        });

        // Event listener for order type change
        orderTypeDropdown.addEventListener('change', function() {
            checkAndShowSections();
        });

        // Event listener for notice type change
        noticeTypeDropdown.addEventListener('change', function() {
            checkAndShowSections();
        });

        // Radio button event listeners
        yesUploadedPlan.addEventListener('change', checkPlanAndPermit);
        noUploadedPlan.addEventListener('change', checkPlanAndPermit);
        yesWorkPermit.addEventListener('change', checkPlanAndPermit);
        noWorkPermit.addEventListener('change', checkPlanAndPermit);

        // Preview button event listener
        previewBtn.addEventListener('click', function() {
            generatePreview();
        });

        // Close preview modal
        closePreview.addEventListener('click', function() {
            previewModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === previewModal) {
                previewModal.style.display = 'none';
            }
        });

        // Function to check and show appropriate sections
        function checkAndShowSections() {
            const selectedBookingType = bookingTypeDropdown.value;
            const selectedOrder = orderTypeDropdown.value;
            const selectedNoticeType = noticeTypeDropdown.value;

            // Hide all conditional sections first
            planPermitSection.style.display = 'none';
            havePlan.style.display = 'none';
            createOrderSection.style.display = 'none';
            section6Form.style.display = 'none';
            stateContainer.style.display = 'none';
            stateContainer2.style.display = 'none';
            buttonSection.style.display = 'none';

            // Update hidden fields
            document.getElementById('booking_type_hidden').value = selectedBookingType;
            document.getElementById('notice_type_hidden').value = selectedNoticeType;
            document.getElementById('relevant_order_hidden').value = selectedOrder;

            // Condition 1: Temporary/Experimental + 14(1) or 14(2)
            if ((selectedBookingType === 'temporary' || selectedBookingType === 'experimental') && 
                (selectedNoticeType === 'Notice of Intent' || selectedNoticeType === 'Notice of Making' || selectedNoticeType === 'Trafic Order') &&
                (selectedOrder === '14 (1) – Full or Partial Road Closure' || selectedOrder === '16(A) Event' || selectedOrder === '15(2)')) {
                if(selectedOrder === '16(A) Event')
                {
                   planPermitSection.style.display = 'block';
                   buttonSection.style.display = 'block';
                checkPlanAndPermit();  
                }else
                {
                  buttonSection.style.display = 'block';
                planPermitSection.style.display = 'block';
                havePlan.style.display = 'block';
                checkPlanAndPermit();
                }
            }
             else   if ((selectedBookingType === 'temporary' || selectedBookingType === 'experimental') && 
                (selectedNoticeType === 'Notice of Intent' || selectedNoticeType === 'Notice of Making' || selectedNoticeType === 'Trafic Order') &&
                (selectedOrder === '14 (2) – Emergency Work Order')) {
                  buttonSection.style.display = 'block';
                createOrderSection.style.display = 'block';
            }
            // Condition 2: Permanent + Section 6
            else if (selectedBookingType === 'permanent' && 
                     (selectedNoticeType === 'Notice of Intent' || selectedNoticeType === 'Notice of Making') &&
                     selectedOrder === 'Section 6') {
                  buttonSection.style.display = 'block';
                section6Form.style.display = 'block';
                document.getElementById('given_notice').value = selectedNoticeType;
            }
        }

        // Function to handle plan and permit radio buttons
        function checkPlanAndPermit() {
            const planYes = document.getElementById('yes_uploaded_your_plan').checked;
            const permitYes = document.getElementById('yes_work_permit').checked;
            
            if(orderTypeDropdown.value === '16(A) Event')
            {
                 
            stateContainer2.style.display = permitYes ? 'block' : 'none';

            
            createOrderSection.style.display = permitYes ? 'block' : 'none'; 
            }else
            {
            // Show file upload if plan is yes
            stateContainer.style.display = planYes ? 'block' : 'none';

            // Show permit number if permit is yes
            stateContainer2.style.display = permitYes ? 'block' : 'none';

            // Show create order section if both are yes
            createOrderSection.style.display = (planYes && permitYes) ? 'block' : 'none';
            }
        }

        // Function to generate preview based on notice type
        function generatePreview() {
            const noticeType = noticeTypeDropdown.value;
            let previewHTML = '';

            // Get form values
            const workPlaces = getWorkPlaces();
            const workPlaceTitles = workPlaces.length > 0 ? workPlaces : ['---'];
             const workPurpose = document.getElementById('work_purpose')?.value || '---';
              const diversionPlans = document.getElementById('diversion_plans')?.value || '---';
              const Location = document.getElementById('location')?.value || '---';
            const title1 = document.getElementById('title_1')?.value || '---';
            const title2 = document.getElementById('title_2')?.value || '---';
            const orderYear = document.querySelector('input[name="order_year"]')?.value || '---';
            const orderUnderSection = document.getElementById('order_under_section')?.value || '---';
             const localAccess = document.getElementById('local_access')?.value || '---';
            const prohibitionTraffic = document.getElementById('prohibition_traffic')?.value || '---';
            let modifiedString = prohibitionTraffic.replace("A or B", "");
            const streetA = document.querySelector('input[name="street_a"]')?.value || '----';
            const streetB = document.querySelector('input[name="street_b"]')?.value || '-----';
            const startTime = document.getElementById('start_time')?.value || '00:01';
            const startDate = document.getElementById('from_date')?.value || '-----';
            const endTime = document.getElementById('end_time')?.value || '-----';
            const endDate = document.getElementById('to_date')?.value || '-----';
            const restrictionType = document.getElementById('effect_orders')?.value || '------';
            const palestra = document.querySelector('input[name="palestra_address"]')?.value || '------';
            const personTitle = document.querySelector('input[name="person_title"]')?.value || '-----';
             const AppropriatePerson = document.querySelector('input[name="appropriate_person"]')?.value || '-----';
           
            // Format dates properly
            const formatDate = (dateString) => {
                if (!dateString) return '---';
                const date = new Date(dateString);
                const day = date.getDate();
                const month = date.toLocaleString('en-US', { month: 'long' });
                const year = date.getFullYear();
                return `${day}${getDaySuffix(day)} ${month} ${year}`;
            };

            const getDaySuffix = (day) => {
                if (day > 3 && day < 21) return 'th';
                switch (day % 10) {
                    case 1: return "st";
                    case 2: return "nd";
                    case 3: return "rd";
                    default: return "th";
                }
            };

            // Format time properly
            const formatTime = (timeString) => {
                if (!timeString) return '12:01 AM';
                const [hours, minutes] = timeString.split(':');
                const hour = parseInt(hours);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const formattedHour = hour % 12 || 12;
                return `${formattedHour}:${minutes} ${ampm}`;
            };

            const formattedStartDate = formatDate(startDate);
            const formattedEndDate = formatDate(endDate);
            const formattedStartTime = formatTime(startTime);
            const formattedEndTime = formatTime(endTime);

            // Get current date for signature
            const currentDate = new Date();
            const currentDay = currentDate.getDate();
            const currentMonth = currentDate.toLocaleString('en-US', { month: 'long' });
            const currentYear = currentDate.getFullYear();
            const currentDaySuffix = getDaySuffix(currentDay);

            if (noticeType === 'Trafic Order') {
                // Template similar to image.png with multiple work places
                const workPlaceList = workPlaceTitles.map(place => place.toUpperCase()).join(' AND ');
                previewHTML = `
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h1 style="font-size: 24px; font-weight: bold;">Transport for London</h1>
                        <h2 style="font-size: 18px; font-weight: bold;">GLA 2009 No. ---</h2>
                          <h1 style="font-size: 20px; font-weight: bold;">THE A ${workPlaceList} GLA ROAD and GLA Side Road (${title1} ${title2}) ORDER ${orderYear}</h1>
                    </div>
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Made</td>
                            <td style="width: 70%;">5th October 2009</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Coming into force</td>
                            <td>${formattedStartDate}</td>
                        </tr>
                    </table>
                    <p>Transport for London in exercise of the powers conferred by Section ${orderUnderSection} of the Road Traffic Regulation Act 1984*, and of all other enabling powers, hereby makes the following Order:—</p>
                    <p>1. This Order may be cited as The A${workPlaceTitles[0]} GLA ROAD (${title1} ${title2}) Order ${orderYear} and shall come into force on the ${formattedStartDate}.</p>
                    <p>2. This Order is made because Transport for London is satisfied that traffic should be ${restrictionType.toLowerCase()}ed because works are being or are proposed to be executed on or near ${Location}.</p>
                    <p>3. During the period starting at ${formattedStartTime} on ${formattedStartDate} and ending at ${formattedEndTime} on ${formattedEndDate} or when those works have been completed, whichever is the sooner, subject to the provisions of article 4 below, no person shall cause or permit any vehicle to enter the affected roads.</p>
                    <p>4.<br>(1) The provisions of article 3 above shall apply only during such times and to such extent as may from time to time be indicated by traffic signs.<br>(2) The provisions specified in article 3 above shall not apply in respect of –<br>&nbsp;&nbsp;&nbsp;&nbsp;(i) any vehicle being used for the purpose of those works;<br>&nbsp;&nbsp;&nbsp;&nbsp;(ii) any vehicle on any occasion when it is being used for fire brigade, ambulance or police purposes if the observance of those provisions would hinder the use of the vehicle;<br>&nbsp;&nbsp;&nbsp;&nbsp;(iii) anything done with the permission or at the direction of a police constable in uniform or a parking attendant.</p>
                    <p style="margin-top: 30px;">Dated this ${currentDay}${currentDaySuffix} day of ${currentMonth} ${currentYear}</p>
                `;
            } else if (noticeType === 'Notice of Intent') {
                // Template similar to image(1).png with dynamic values and multiple work places
                const workPlaceList = workPlaceTitles.map(place => place.toUpperCase()).join(' AND ');
                previewHTML = `
                    <div style="text-align: center; margin-bottom: 20px;">
                     <h1 style="font-size: 20px; font-weight: bold;">TRANSPORT FOR LONDON</h1>
                     <h1 style="font-size: 20px; font-weight: bold;">PUBLIC NOTICE</h1>
                      <h1 style="font-size: 20px; font-weight: bold;">ROAD TRAFFIC REGULATION ACT 1984</h1>
                        <h1 style="font-size: 20px; font-weight: bold;">THE A ${workPlaceList} GLA ROAD (FARRINGDON STREET ,CITY OF LONDON) (${title1} ${title2}) ORDER ${orderYear}</h1>
                    </div>
                    <p>1. Transport for London hereby gives notice that it intends to make the above-named Traffic Order under section ${orderUnderSection} of the Road Traffic Regulation Act 1984 for the purpose specified in paragraph 2. The effect of the Order is summarised in paragraph 3.</p>
                    <p>2. The purpose of the Order is to enable ${workPurpose} works to take place on ${Location}.</p>
                    <p>3. The effect of the Order will be to ${modifiedString.toLowerCase()}  ${streetA} and ${streetB}.</p>
                    <p>Local access will be maintained between ${localAccess}.</p>
                    <p>The Order will be effective between ${formattedStartDate} and ${formattedEndDate} from ${formattedStartTime} until ${formattedEndTime} or when the works have been completed whichever is the sooner. The ${restrictionType.toLowerCase()}ions will apply only during such times and to such extent as shall from time to time be indicated by traffic signs.</p>
                    <p>4. The ${restrictionType.toLowerCase()}ions will not apply in respect of:<br>&nbsp;&nbsp;&nbsp;&nbsp;(1) any vehicle being used for the purposes of these works or for fire brigade, ambulance or police purposes;<br>&nbsp;&nbsp;&nbsp;&nbsp;(2) anything done with the permission or at the direction of a police constable in uniform or a person authorised by Transport for London.</p>
                    <p>5. At such times as the ${restrictionType.toLowerCase()}ions are in force alternative routes will be indicated by traffic signs via (${diversionPlans}).</p>
                    <p style="margin-top: 30px;">Dated this ${currentDay}${currentDaySuffix} day of ${currentMonth} ${currentYear}</p>
                    <p><strong>${AppropriatePerson}</strong><br><strong>${personTitle}</strong><br>${palestra}</p>
                `;
            } else if (noticeType === 'Notice of Making') {
                // Template similar to image(2).png with multiple work places
                const workPlaceList = workPlaceTitles.map(place => place.toUpperCase()).join(' AND ');
                previewHTML = `
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h1 style="font-size: 20px; font-weight: bold;">Transport for London</h1>
                        <h2 style="font-size: 16px; font-weight: bold;">PUBLIC NOTICE:</h2>
                        <h3 style="font-size: 14px; font-weight: bold;">ROAD TRAFFIC REGULATION ACT 1984</h3>
                           <h1 style="font-size: 20px; font-weight: bold;">THE A ${workPlaceList} GLA ROAD (FARRINGDON STREET ,CITY OF LONDON) (${title1} ${title2}) ORDER ${orderYear}</h1>
                    </div>
                    <p>1. Transport for London hereby gives notice that it has made the above named Order under section ${orderUnderSection} of the Road Traffic Regulation Act 1984 for the purpose specified in paragraph 2. The effect of the Order is summarised in paragraph 3..</p>
                    <p>2. The purpose of the Order is to enable ${workPurpose} works to take place on or near  ${Location}.[because of likelihood of danger to the public or of seriouse damage to the road][to enable little clearing and cleaning to be discharged][to enable resurfacing]</p>
                   <p>3. The effect of the Order will be ${restrictionType.toLowerCase()} to ${modifiedString.toLowerCase()}  ${streetA} and ${streetB}.</p>
                    <p>The Order will be effective at certain time from ${formattedStartTime} on the ${formattedStartDate} until ${formattedEndTime} on the ${formattedEndDate}  or when the works have been completed whichever is the sooner. The ${restrictionType.toLowerCase()}ions will apply only during such times and to such extent as shall from time to time be indicated by traffic signs.</p>
                     <p>4. The ${restrictionType.toLowerCase()}ions will not apply in respect of:<br>&nbsp;&nbsp;&nbsp;&nbsp;(1) any vehicle being used for the purposes of these works or for fire brigade, ambulance or police purposes;<br>&nbsp;&nbsp;&nbsp;&nbsp;(2) anything done with the permission or at the direction of a police constable in uniform or a person authorised by Transport for London.</p>
                    <p>5. At such times as the ${restrictionType.toLowerCase()}ions are in force alternative routes will be indicated by traffic signs via (${diversionPlans}).</p>
                    <p style="margin-top: 30px;">Dated this ${currentDay}${currentDaySuffix} day of ${currentMonth} ${currentYear}</p>
                    <p><strong>${AppropriatePerson}</strong><br><strong>${personTitle}</strong><br>${palestra}</p>
                `;
            } else {
                previewHTML = '<p>Please select a notice type to preview the template.</p>';
            }

            previewTemplate.innerHTML = previewHTML;
            previewModal.style.display = 'block';
        }

        // Initialize
        checkAndShowSections();
        updateRemoveButtons();
    });
</script>
@endsection
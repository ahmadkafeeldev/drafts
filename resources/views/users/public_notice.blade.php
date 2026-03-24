@extends('layouts.drafts.app')

@section('title', 'Public Notice')

@section('styles')

@endsection
    

        @php

            $specificOrderTypeDrafts14_1            = $drafts->where('order_type', '14 (1) – Full or Partial Road Closure');
            $emergencyWorkDrafts                    = $drafts->where('order_type', '14 (2) – Emergency Work Order');
            $specificOrderTypeDrafts16_a            = $drafts->where('order_type', '16 (A) – Special Events');
            $specificOrderTypeDrafts_section_23     = $drafts->where('order_type', 'Section 23 Pedestrian Notices');
        
            
            $section_6                      = $drafts->where('order_type', 'Section 6');
            $Banned_Turn_Order              = $drafts->where('order_type', 'Banned Turn Order');
            $Prescribed_Route_Order         = $drafts->where('order_type', 'Prescribed Route Order');
            $Bus_Priority_Orders            = $drafts->where('order_type', 'Bus Priority Orders');
            $Clearway_Orders                = $drafts->where('order_type', 'Clearway Orders');
            $Cycle_Lane_Order               = $drafts->where('order_type', 'Cycle Lane Order');
            $Cycle_Track_Notices            = $drafts->where('order_type', 'Cycle Track Notices');
            $Speed_Limit_83_84            = $drafts->where('order_type', 'Speed Limit 83 & 84');
            $Variation_Orders               = $drafts->where('order_type', 'Variation Orders');
            $Consolidated_Orders            = $drafts->where('order_type', 'Consolidated Orders');
            $Parking_Control_Orders         = $drafts->where('order_type', 'Parking Control Orders');
            $Priority_Traffic_Lane          = $drafts->where('order_type', 'Priority Traffic Lane');
            $Section_9_Experimental         = $drafts->where('order_type', 'Section 9 Experimental');
            $Section_9_6                    = $drafts->where('order_type', 'Section 9-6');
            $Section_9_83                   = $drafts->where('order_type', 'Section 9-83/84');
            $Revocation_Order               = $drafts->where('order_type', 'Revocation Order');
            $Modification_Order             = $drafts->where('order_type', 'Modification Order');
        @endphp


@section('content')

<!-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

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


<!-- @foreach($drafts as $draft)
    @if($draft->booking_type == 'Permanent')
        <p class="font-normal text-blue-500">{{ $draft->booking_type }}: {{ $draft->order_type }} - {{ $draft->notice_type }}</p>
    @elseif($draft->booking_type == 'Temporary')
        <p class="font-normal text-slate-500">{{ $draft->booking_type }}: {{ $draft->order_type }} - {{ $draft->notice_type }}</p>
    @endif
@endforeach -->



<div class="container mx-auto p-4 py-10 sm:p-10">

    <!-- Container to display selected content -->
    <div id="content_container"></div>

    <!-- Form Steps -->
    <form action="#" method="POST" class="px-5 py-10">
        
    <!-- Step 1 -->
        <div class="form-step active" id="step-1">
    
            <!-- Traffic Order Type Dropdown -->
            <div class="row mb-3">
                <div class="form-group col-md-12 col-sm-12">
                    <label for="booking_type" class="block text-gray-700 font-semibold mb-2">Traffic Order Type</label>
                    <select class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        name="booking_type" id="booking_type" required>
                        <option disabled selected>*Select Advertisement Type*</option>
                        <option value="temporary">Temporary</option>
                        <option value="permanent">Permanent</option>
                        <option value="experimental">Experimental</option>
                    </select>
                </div>
            </div>

        
            <!-- Notice Type Dropdown -->
        
            <div class="row mb-3">
            <div class="form-group col-md-12 col-sm-12">
                <label for="notice_type" class="block text-gray-700 font-semibold mb-2">Select Type of Notice</label>
                <select class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    name="notice_type" id="notice_type" required>
                    <option disabled selected>*Select Type of Notice*</option>
                    <option>Notice of Intent</option>
                    <option>Notice of Making</option>
                </select>
            </div>
        </div>

        <!-- Relevant Order Dropdown -->
        <div class="row mb-3">
            <div class="form-group col-md-12 col-sm-12">
                <label for="order_type" class="block text-gray-700 font-semibold mb-2">Select Relevant Order</label>
                <select class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    name="order_type" id="order_type" required>
                    <option disabled selected>*Select Relevant Order*</option>
                </select>
            </div>
        </div>

        <!-- Next Step Button -->
        <button type="button"
            class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center next-step">
            Next Step
        </button>

</div>


    <!-- Check if there are drafts for the specific 'order_type' -->
    @if($specificOrderTypeDrafts14_1->isNotEmpty())
        
    <!-- Step 2 -->
    <div class="form-step" id="full_partial_road_closure_content" style="display: none;">
        <div class="my-5 w-full rounded p-4">
            <div class="flex flex-wrap items-start justify-between">
                <div class="left w-full lg:w-1/2 pr-4">
                    <!-- Plan Upload Radio Buttons -->
                    <div class="form-check flex flex-wrap items-center gap-3 py-2">
                        <label for="uploaded_your_plan" class="block mb-2 text-lg font-bold text-gray-900">
                            Have you uploaded your plan?
                        </label>
                        <div class="flex items-center">
                            <input id="yes_uploaded_your_plan" type="radio" value="yes" name="yes_uploaded_plan"
                                class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 h-4 w-4 rounded-full">
                            <label for="yes_uploaded_your_plan"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="no_uploaded_your_plan" type="radio" value="no"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                checked>
                            <label for="no_uploaded_your_plan"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                        </div>
                    </div>

                    <!-- Hidden field for file upload -->
                    <div class="form-check flex flex-wrap items-center gap-3 py-2" id="state-container" style="display: none;">
                        <input type="file" name="uploaded_plan" id="plan_file" class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block mx-2 w-full"
                            placeholder="If yes, please state" required />
                    </div>

                    <!-- Work Permit Radio Buttons -->
                    <div class="form-check flex flex-wrap items-center gap-3 py-2">
                        <label for="work_permit" class="block mb-2 text-lg font-bold text-gray-900">
                            Have you applied and got approval for work permit?
                        </label>
                        <div class="flex items-center">
                            <input id="yes_work_permit" type="radio" value="yes" name="yes_approval_work_permit"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="yes_work_permit"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="no_work_permit" type="radio" value="no"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                checked>
                            <label for="no_work_permit"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                        </div>
                    </div>

                    <p class="mb-3 text-xl text-blue-500 w-full md:text-xl">
                        <span>If yes, please provide your permit number</span>
                    </p>

                    <!-- Hidden field for permit number -->
                    <div class="form-check flex flex-wrap items-center gap-3 py-2" id="state-container-2" style="display: none;">
                        <input type="text" id="permit_number" 
                        name="approval_work_permit" 
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block mx-2 w-full"
                            placeholder="Add your Permit Number" required />
                    </div>
                </div>

                <!-- Map Section -->
                <div class="right w-full lg:w-1/2">

                    <iframe 
                    src="https://www.google.com/maps/d/embed?mid=1KE3Tlm1Bhe4ZbE5bzhD69BZb7Js&hl=en_US&ehbc=2E312F" 
                        class="rounded-lg w-full h-80 md:h-screen lg:h-full" frameborder="0" style="border:0;" allowfullscreen="">
                    </iframe>
                </div>
            </div>

            <div class="flex items-center w-full justify-between mt-4">
                <button type="button"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center prev-step">
                    Previous Step
                </button>

                <button type="button"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center next-step">
                    Next Step
                </button>
            </div>
        </div>
    </div>

        <!-- Step 3 -->
        <div class="form-step" id="step-3" style="display: none;">
            <div class="w-full rounded">
                
            <h3 class="mb-4 text-4xl text-start font-bold leading-none text-gray-900">PUBLIC NOTICE: ROAD TRAFFIC REGULATION ACT 1984</h3>
            
            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span>Which Street is the work taking place?</span>
                    <input type="text" id="dated_this" name="street_place"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="or Example A10 GLA Road. (2) NB, SB, EB or WB?" required />
            </p>

            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span>Which Authourit(ies) is apply?</span>
                    <input type="text" id="dated_this" name="authourities"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="Authourit(ies)" required />
            </p>

            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span>Which Borough is it?</span>
                    <input type="text" id="dated_this" name="borough"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="London Newspaper of XYZ" required />
            </p>

            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span>What type of work?</span>
                    <input type="text" id="dated_this" name="order_type_2"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="For example, Full closure" required />
            </p>

            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span>What is the purpose of the work</span>
                    <input type="text" id="dated_this" name="work_purpose"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="Write your work purpose" required />
            </p>

            <div class="mb-3 text-lg flex flex-row items-center justify-between text-gray-800 w-full gap-3 md:text-xl">
                <span for="uploaded_your_plan" class="mb-3 text-lg text-gray-800 md:text-xl">
                    Is it day work or night?
                </span>
                <div class="form-check flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <input id="day" type="radio" value="yes" name="day_or_night"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="day"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Day</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="night" type="radio" value="no" name="day_or_night"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            checked>
                        <label for="night"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Night</label>
                    </div>
                </div>
            </div>


            <div class="mb-3 text-lg flex flex-row items-center justify-between text-gray-800 w-full gap-3 md:text-xl">
                <span for="uploaded_your_plan" class="mb-3 text-lg text-gray-800 md:text-xl w-1/2">From what date to what date?</span>
                <div class="flex gap-3 w-full">
                    <input type="date" id="from_date" name="start_date"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="From date" required />
                    <input type="date" id="to_date" name="end_date"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="To date" required />
                </div>
            </div>


            <div class="mb-1 text-lg flex flex-row items-center justify-between text-gray-800 w-full gap-3 md:text-xl">
                <span class="mb-3 text-lg text-gray-800 md:text-xl">
                    Does another traffic or highway authority need to be informed (section 101 agreement)?
                </span>
                <div class="form-check flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <input id="yes_section_101_agreement" type="radio" value="yes" name="highway_authority_informed"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="yes_section_101_agreement"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="no_section_101_agreement" type="radio" value="no" name="highway_authority_informed"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            checked>
                        <label for="no_section_101_agreement"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                    </div>
                </div>
            </div>

            <!-- Hidden section that shows when "Yes" is selected -->
            <div class="mb-4" id="yes_borough_councel" style="display: none;">
                <p class="text-lg flex flex-row items-center justify-between text-blue-500 w-full gap-3 md:text-xl">
                    <span class="w-1/2">Yes, Please type Borough(s)/Council names</span>       
                    <input type="text" id="borough_names" name="yes_council_names"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="Borough(s)/Council names" required />
                </p>
                <p class="text-lg flex flex-row items-center justify-between text-blue-500 w-full gap-3 md:text-xl">
                    <span class="w-1/2">NOT SURE, you can type the Road/Street into this link to check Borough/Council boundaries.</span>       
                    <a href="{{ route('user.map') }}" id="council_boundaries" class="font-medium text-xl text-blue-600 hover:underline">Go to map to draw your boundaries</a>
                </p>
            </div>

            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                    <span class="w-1/2">What are the diversion plans if there are?</span>
                    <input type="text" id="dated_this" name="diversion_plans"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                        placeholder="traffic or highway authority" required />
            </p>

            <div class="flex items-center w-full justify-between mt-4">
                <button type="button"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center prev-step">
                    Previous Step
                </button>

                <button type="button"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center next-step">
                    Next Step
                </button>
            </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="form-step" id="step-4" style="display: none;">
            <div class="flex items-center justify-center">
                <input type="text" id="transport_name" name="transport_for_london"
                        class="border-none rounded-full text-4xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                        placeholder="Transport for London" required />
            </div>
            <h3 class="mb-4 text-3xl text-center font-medium leading-none text-gray-900">PUBLIC NOTICE: </h3>
            <h3 class="mb-4 text-3xl text-center font-medium leading-none text-gray-900">ROAD TRAFFIC REGULATION ACT 1984</h3>

            <div class="container mx-auto">
                <div class="flex flex-wrap justify-center items-center my-3">
                    <h3 class="mb-4 text-3xl text-center font-bold leading-none text-gray-90 pt-4">THE A</h3>
                    <input type="text" id="a_street" name="A_10"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  w-[60px] mx-2"
                        placeholder="A10" required />
                    <h3 class="mb-4 text-3xl text-center font-bold leading-none text-gray-90 pt-4">GLA ROAD</h3>
                    <input type="text" id="a_street" name="borough_2"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  mx-2"
                        placeholder="(----- BOROUGH -----)" required />
                    <h3
                        class="mb-4 text-3xl text-center leading-none text-gray-90 flex flex-wrap justify-center items-center">
                        <span class="font-bold">(TEMPORARY</span>
                        <input type="text" id="a_street" name="prohibition_traffic"
                            class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  mx-2"
                            placeholder="Prohibition of Traffic" required />
                        <span class="font-bold">) ORDER 202-</span>
                        <select id="transport_name" name="order_year"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="January">4</option>
                                    <option value="February">5</option>
                                    <option value="March">6</option>
                                    <option value="April">7</option>
                                    <option value="May">8</option>
                                    <option value="June">9</option>
                                </select>
                    </h3>
                </div>

                <div class="flex flex-wrap justify-center items-center mt-3">
                    <ol class="list-decimal ">
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            <input type="text" id="transport_name" name="transport_for_london_2"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London" required /> 
                        <span>hereby gives notice that it intends to make the above named
                            Traffic Order under section <input type="text" name="order_under_section" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="14(1)" required /> of the Road Traffic Regulation Act 1984 for the
                            purpose specified in paragraph 2. The effect of the Order is summarised in
                            paragraph 3.</span>
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The purpose of the Order is to enable 
                            <input type="text" id="transport_name" name="order_type_3"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="[enter type of works]" required /> works to take place at
                            <input type="text" id="transport_name" name="place_at"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Place at A13" required />. [because of the likelihood of danger to the public or of
                            serious damage to the road] [to enable litter clearing and cleaning to be
                            discharged] [to enable resurfacing]
                        </li>
                        <li class="mb-3 text-lg text-gray-800 md:text-xl flex flex-wrap gap-3">
                            The effect of the Order will be to 
                            <input type="text" id="transport_name" name="effect_orders"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="[prohibit] [restrict] [suspend]" required /> any vehicle from
                            <input type="text" id="transport_name" name="vehicle_from"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="turning left or right from Commercial Road into Butcher Row" required />. 
                                The Order will be effective at certain times from 
                                <input type="time" id="transport_name" name="effective_at_certain_times"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="--.— [AM PM]" required />
                            on the <select id="transport_name" name="from_month"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                202-<select id="transport_name" name="from_year"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="January">4</option>
                                    <option value="February">5</option>
                                    <option value="March">6</option>
                                    <option value="April">7</option>
                                    <option value="May">8</option>
                                    <option value="June">9</option>
                                </select> until 
                                <input type="time" id="transport_name" name="until_time"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="--.— [AM PM]" required />
                                on the <select id="transport_name" name="until_month"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select> 202-<select id="transport_name" name="until_year"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="January">4</option>
                                    <option value="February">5</option>
                                    <option value="March">6</option>
                                    <option value="April">7</option>
                                    <option value="May">8</option>
                                    <option value="June">9</option>
                                </select> or when the works
                            have been completed whichever is the sooner. The prohibition will apply only
                            during such times and to such extent as shall from time to time be indicated by
                            traffic signs.
                        </li>
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The prohibitions will not apply in respect of:
                            <ol>
                                <li class="mb-2 text-lg text-gray-800 md:text-xl">(1) any vehicle being used for the
                                    purposes of those works or for fire brigade,
                                    ambulance or police purposes; </li>
                                <li class="mb-3 text-lg text-gray-800 md:text-xl">(2) anything done with the permission
                                    or at the direction of a police constable in
                                    uniform or a person authorised by <input type="text" 
                                    id="transport_name" name="transport_for_london_3"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London" required />.</li>
                            </ol>
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            At such times as the prohibition is in force an alternative route will be indicated by
                            traffic signs <input type="text" 
                            id="transport_name" 
                            name="traffic_signs_via"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="[via---]" value="[via---]" required />.
                        </li>
                    </ol>
                </div>

                <p class="mb-3 text-lg flex flex-wrap items-center text-gray-800 md:text-xl">
                    <span>Dated this</span>
                    <input type="number" id="dated_this" name="date_day"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-[100px] mx-2"
                        placeholder="21st" required />
                    <span>day of</span>
                    <input type="text" id="dated_this" name="date_month"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  w-[100px] mx-2"
                        placeholder="January" required />
                    <span>202-</span>
                    <select id="transport_name" name="date_year"
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                </p>

                
                <div class="flex flex-col w-full my-5">
                    <h3 class="mb-3 text-lg text-gray-900 font-bold md:text-xl">Signature</h3>
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" name="signatures" type="file" class="hidden" />
                    </label>
                </div> 
            </div>

            <div class="hidden" id="emergency">
                    <h3 class="mb-2 text-lg text-gray-900 font-bold md:text-xl">Appropriate Person</h3>
                    <div class="mb-2 text-lg text-gray-800 md:text-xl"> 
                        <span class="text-lg text-gray-900 font-bold md:text-xl">
                            <input type="text" id="transport_name" name="person_title"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Person Title" value="Person Title" required />, </span>
                        <span class="font-normal">
                            <input type="text" id="transport_name" name="transport_for_london_4"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London"  required /></span> 
                    </div>
                    <div class="mb-4 text-lg text-gray-800 md:text-xl font-normal">
                        <input type="text" id="transport_name" name="palestra_address"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Palestra, 197 Blackfriars Road, London, SE1 8NJ" value="Palestra, 197 Blackfriars Road, London, SE1 8NJ" required /></div>
                </div>

            <div class="flex items-center w-full justify-between mt-4">
                <button type="button"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center prev-step">
                    Previous Step
                </button>

                <button type="button" id="submit"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">
                    Submit
                </button>
            </div>

        </div>
        @endif
    </form>
</div>

<!-- Permanent - Section 6 Intent -->
<form action="!#" class="container mx-auto p-4 py-10 sm:p-10 form-step-permanent-s-6_intent my-4" id="form_step_permanent_s_6" style="display: none;">
    <div>
            <h1 class="mb-4 text-3xl font-bold leading-none text-center text-gray-90 bg-slate-100 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                Section 6 - ROAD TRAFFIC REGULATION ACT 1984
            </h1>
            <div class="flex items-center justify-center">
                <input type="text" id="transport_name"
                        class="border-none rounded-full text-4xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                        placeholder="Transport for London"  required />
            </div>
            <div class="flex items-center justify-center">
                <h1 class="text-2xl font-bold leading-none text-center text-slate-500 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                    PUBLIC NOTICE:
                </h1>
            </div>

            <div class="flex items-center justify-center">
                <h1 class="text-2xl font-bold leading-none text-center text-slate-500 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                    ROAD TRAFFIC REGULATION ACT 1984
                </h1>
            </div>

            <div class="flex items-center justify-center">
                <input type="text" id="transport_name"
                        class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                        placeholder="THE GLA ROADS ..." required />
            </div>

            <div class="container mx-auto">

                <div class="flex flex-wrap items-center my-5">
                    <ol class="list-decimal ">
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London" required /> , 
                                hereby gives notice that it intends to make the above named Order under section 6 of the Road Traffic Regulation Act 1984.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The general nature and effect of the Order will be to <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                placeholder="type here" required />.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The road which would be affected by the Order is <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                placeholder="type here" required />.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            A copy of the Order, a statement of <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London’s" required /> reasons for the proposals, a map indicating the location and 
                            effect of the Order and copies of any Order revoked, suspended or varied by the Order can be inspected 
                            during normal office hours at the offices of:

                            <ul class="my-1">
                                <li>
                                    •	<input type="text" id="transport_name"
                                            class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                            placeholder="Transport for London Streets Traffic Order Team (RSM/PI/STOT) Palestra, 197 Blackfriars Road London, SE1 8NJ" required />
                                </li>
                            </ul>
                            
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                All objections and other representations to the proposed Order must be made in 
                                writing and must specify the grounds on which they are made. Objections and representations must be sent to 
                                <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London" required />, <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Streets Traffic Order Team, Palestra, 197 Blackfriars Road, London, SE1 8NJ" required /> quoting reference 
                                <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="RSM/PI/STOT/TRO" required />, <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="GLA/20--/----" required />, to arrive before <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="-- ---------- 201-" required />.  Objections and other representations 
                                may be communicated to other persons who may be affected.
                        </li>

                        <p class="my-4 text-lg flex flex-wrap items-center text-gray-800 md:text-xl">
                    <span>Dated this</span>
                    <input type="number" id="dated_this"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-[100px] mx-2"
                        placeholder="21st" required />
                    <span>day of</span>
                    <input type="text" id="dated_this"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  w-[100px] mx-2"
                        placeholder="January" required />
                    <span>202-</span>
                    <select id="transport_name" 
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="January">4</option>
                                    <option value="February">5</option>
                                    <option value="March">6</option>
                                    <option value="April">7</option>
                                    <option value="May">8</option>
                                    <option value="June">9</option>
                                </select>
                </p>

<div id="emergency">
                    <h3 class="mb-2 text-lg text-gray-900 font-bold md:text-xl">Appropriate Person</h3>
                    <div class="mb-2 text-lg text-gray-800 md:text-xl"> 
                        <span class="text-lg text-gray-900 font-bold md:text-xl"><input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Person Title" value="Person Title" required />, </span>
                        <span class="font-normal">
                            <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London"  required /></span> 
                    </div>
                    <div class="mb-4 text-lg text-gray-800 md:text-xl font-normal">
                        <input type="text" id="transport_name"
                                class="border-none rounded-full bg-slate-100 font-bold leading-none text-gray-900 w-1/2"
                                placeholder="Palestra, 197 Blackfriars Road, London, SE1 8NJ" value="Palestra, 197 Blackfriars Road, London, SE1 8NJ" required /></div>
                </div>
                    
                    </ol>
                </div>

            
                <button type="button" id="form_step_permanent_s_6" data-modal-target="section-6-modal" data-modal-toggle="section-6-modal"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">
                    Verify
                </button>
        </div>
        </div>
</form>


<!-- Permanent - Section 6 Making -->
<form action="!#" class="container mx-auto p-4 py-10 sm:p-10 form-step-permanent-s-7 my-4" id="form_step_permanent_s_6_making" style="display: none;">
    <div>
            <h1 class="mb-4 text-3xl font-bold leading-none text-center text-gray-90 bg-slate-100 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                Section 6 - ROAD TRAFFIC REGULATION ACT 1984
            </h1>
            <div class="flex items-center justify-center">
                <input type="text" id="form_step_permanent_s_6_making_transport_london"
                        class="border-none rounded-full text-4xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                        placeholder="Transport for London"  required />
            </div>
            <div class="flex items-center justify-center">
                <h1 class="text-2xl font-bold leading-none text-center text-slate-500 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                    PUBLIC NOTICE:
                </h1>
            </div>

            <div class="flex items-center justify-center">
                <h1 class="text-2xl font-bold leading-none text-center text-slate-500 rounded md:text-3xl md:leading-none md:text-left py-5 px-3">
                    ROAD TRAFFIC REGULATION ACT 1984
                </h1>
            </div>

            <div class="flex items-center justify-center">
                <input type="text" id="form_step_permanent_s_6_making_gla_raods"
                        class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                        placeholder="THE GLA ROADS ..." required />
            </div>

            <div class="container mx-auto">

                <div class="flex flex-wrap items-center my-5">
                    <ol class="list-decimal ">
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            AUTHORITY hereby gives notice that on <input type="text" id="form_step_permanent_s_6_making_given_notice"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="-- ------- 2013" required /> it made the above named Order, under section 6 
                            of the Road Traffic Regulation Act 1984. The Order will come into force on <input type="text" id="form_step_permanent_s_6_making_force_on"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="-- ------- 2013" required />.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The general nature and effect of the Order will be to <input type="text" id="form_step_permanent_s_6_making_general_nature"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                placeholder="type here" required />.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The road which would be affected by the Order is <input type="text" id="form_step_permanent_s_6_making_road_affected"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                placeholder="type here" required />.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            A copy of the Order, a statement of <input type="text" id="form_step_permanent_s_6_making_copy_of_order"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London’s" required /> reasons for the proposals, a map indicating the location and 
                                effect of the Order and copies of any Order revoked, suspended or varied by the Order can be inspected 
                                during normal office hours at the offices of:

                            <ul class="my-1">
                                <li>
                                    •	<input type="text" id="form_step_permanent_s_6_making_streets_traffic_order"
                                            class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900 w-1/2"
                                            placeholder="Transport for London Streets Traffic Order Team (RSM/PI/STOT) Palestra, 197 Blackfriars Road London, SE1 8NJ" required />
                                </li>
                            </ul>
                            
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                Any person wishing to question the validity of the Order or of any of its provisions on the grounds that they are not 
                                within the relevant powers conferred by the Act or that any requirement of the Act has not been complied with, that 
                                person may, within six weeks from the date on which the Order is made, make application for the purpose to the High Court.
                        </li>

                        <p class="my-4 text-lg flex flex-wrap items-center text-gray-800 md:text-xl">
                    <span>Dated this</span>
                    <input type="number" id="form_step_permanent_s_6_making_dated_this"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-[100px] mx-2"
                        placeholder="21st" required />
                    <span>day of</span>
                    <input type="text" id="form_step_permanent_s_6_making_month"
                        class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block  w-[100px] mx-2"
                        placeholder="January" required />
                    <span>202-</span>
                    <select id="form_step_permanent_s_6_making_year" 
                                        class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900" 
                                        required>
                                    <option value="" disabled selected>Year</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                </select>
                </p>

<div class="mt-6" id="emergency">
                    <h3 class="mb-2 text-lg text-gray-900 font-bold md:text-xl">Appropriate Person</h3>
                    <div class="mb-2 text-lg text-gray-800 md:text-xl"> 
                        <span class="text-lg text-gray-900 font-bold md:text-xl"><input type="text" id="form_step_permanent_s_6_making_person_title"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Person Title" value="Person Title" required />, </span>
                        <span class="font-normal">
                            <input type="text" id="form_step_permanent_s_6_making_transport_for_london_2"
                                class="border-none rounded-full bg-slate-100 text-center font-bold leading-none text-gray-900"
                                placeholder="Transport for London"  required /></span> 
                    </div>
                    <div class="mb-4 text-lg text-gray-800 md:text-xl font-normal">
                        <input type="text" id="form_step_permanent_s_6_making_road_london"
                                class="border-none rounded-full bg-slate-100 font-bold leading-none text-gray-900 w-1/2"
                                placeholder="Palestra, 197 Blackfriars Road, London, SE1 8NJ" required /></div>
                </div>
                    
                    </ol>
                </div>

            
                <button type="button" id="form_step_permanent_s_6_making_Verify_submit" data-modal-target="section-6-making-modal" data-modal-toggle="section-6-making-modal"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">
                    Verify
                </button>
        </div>
        </div>
</form>


<!-- Section 6 Making Notice - Main modal -->
<div id="section-6-making-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Section 6
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="section-6-making-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="p-5">
                    <div class="flex items-center justify-center mb-3">
                        <h1 id="form_step_permanent_s_6_making_transport_london_text"
                                class="border-none rounded-full text-4xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                                >Transport for London</h1>
                    </div>
                    <div class="flex items-center justify-center mb-3">
                         <h1 id="form_step_permanent_s_6_making_public_notice_text"
                                class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                >PUBLIC NOTICE:</h1>
                    </div>

            <div class="flex items-center justify-center mb-3">
                <h1 id="form_step_permanent_s_6_making_traffic_road_regulation_text"
                                    class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                    >ROAD TRAFFIC REGULATION ACT 1984</h1>    
            </div>

            <div class="flex items-center justify-center mb-2">
                 <h1 id="form_step_permanent_s_6_making_gla_raods_text"
                                    class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                    >THE GLA ROADS ...</h1>
            </div>

            <div class="container mx-auto">

                <div class="flex flex-wrap items-center my-5">
                    <ol class="list-decimal ">
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            AUTHORITY hereby gives notice that on <span id="form_step_permanent_s_6_making_given_notice_text">-- ------- 2013</span> it made the above named Order, under section 6 
                            of the Road Traffic Regulation Act 1984. The Order will come into force on <span id="form_step_permanent_s_6_making_given_notice_2_text">-- ------- 2013</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The general nature and effect of the Order will be to 
                            <span id="form_step_permanent_s_6_making_general_nature_text">lorem ipsum aj ashd  heheiuieo</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The road which would be affected by the Order is <span id="form_step_permanent_s_6_making_road_affected_text">Typed lorem ipsum aj ashd  heheiuieo</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            A copy of the Order, a statement of 
                                <span id="form_step_permanent_s_6_making_copy_of_order_text">Transport for London’s</span> 
                                reasons for the proposals, a map indicating the location and 
                                effect of the Order and copies of any Order revoked, suspended or varied by the Order can be inspected 
                                during normal office hours at the offices of:

                            <ul class="my-1">
                                <li>
                                    •	<span id="form_step_permanent_s_6_making_streets_traffic_order_text">Transport for London Streets Traffic Order Team (RSM/PI/STOT) Palestra, 197 Blackfriars Road London, SE1 8NJ</span>
                                </li>
                            </ul>
                            
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                Any person wishing to question the validity of the Order or of any of its provisions on the grounds that they are not 
                                within the relevant powers conferred by the Act or that any requirement of the Act has not been complied with, that 
                                person may, within six weeks from the date on which the Order is made, make application for the purpose to the High Court.
                        </li>

                        <p class="my-4 text-lg flex flex-wrap items-center text-gray-800 md:text-xl">
                            <span>Dated this</span>
                            <span id="form_step_permanent_s_6_making_dated_this_text">21st</span>
                            <span>day of</span>
                            <span id="form_step_permanent_s_6_making_month_text">January</span>
                            <span>202</span>
                            <span id="form_step_permanent_s_6_making_year_text">2</span>
                        </p>

<div class="mt-6" id="emergency">
                    <h3 class="mb-2 text-lg text-gray-900 font-bold md:text-xl">Appropriate Person</h3>
                    <div class="mb-2 text-lg text-gray-800 md:text-xl"> 
                        <span class="text-lg text-gray-900 font-bold md:text-xl">
                            <span id="form_step_permanent_s_6_making_person_title_text">Person Title</span>, </span>
                        <span class="font-normal">
                            <span id="form_step_permanent_s_6_making_transport_for_london_2_text">Transport for London</span></span> 
                    </div>
                    <div class="mb-4 text-lg text-gray-800 md:text-xl font-normal">
                        <span id="form_step_permanent_s_6_making_road_london_text">Palestra, 197 Blackfriars Road, London, SE1 8NJ</span>
                    </div>
                </div>
                    
                    </ol>
                </div>
               <button type="button" id="form_step_permanent_s_6_making_submit" data-modal-target="section-6-making-modal" data-modal-toggle="section-6-making-modal"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Section 6 Intent Notice - Main modal -->
<div id="section-6-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Section 6
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="section-6-making-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="p-5">
                    <div class="flex items-center justify-center mb-3">
                        <h1 id="form_step_permanent_s_6_making_transport_london_text"
                                class="border-none rounded-full text-4xl bg-transparent text-center font-bold leading-none text-gray-900 w-full"
                                >Transport for London</h1>
                    </div>
                    <div class="flex items-center justify-center mb-3">
                         <h1 id="form_step_permanent_s_6_making_public_notice_text"
                                class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                >PUBLIC NOTICE:</h1>
                    </div>

            <div class="flex items-center justify-center mb-3">
                <h1 id="form_step_permanent_s_6_making_traffic_road_regulation_text"
                                    class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                    >ROAD TRAFFIC REGULATION ACT 1984</h1>    
            </div>

            <div class="flex items-center justify-center mb-2">
                 <h1 id="form_step_permanent_s_6_making_gla_raods_text"
                                    class="border-none rounded-full text-3xl bg-transparent text-center font-bold leading-none text-gray-800 w-full"
                                    >THE GLA ROADS ...</h1>
            </div>

            <div class="container mx-auto">

                <div class="flex flex-wrap items-center my-5">
                    <ol class="list-decimal ">
                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            AUTHORITY hereby gives notice that on <span id="form_step_permanent_s_6_making_given_notice_text">-- ------- 2013</span> it made the above named Order, under section 6 
                            of the Road Traffic Regulation Act 1984. The Order will come into force on <span id="form_step_permanent_s_6_making_given_notice_2_text">-- ------- 2013</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            The general nature and effect of the Order will be to 
                            <span id="form_step_permanent_s_6_making_general_nature_text">lorem ipsum aj ashd  heheiuieo</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The road which would be affected by the Order is <span id="form_step_permanent_s_6_making_road_affected_text">Typed lorem ipsum aj ashd  heheiuieo</span>.
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                            A copy of the Order, a statement of 
                                <span id="form_step_permanent_s_6_making_copy_of_order_text">Transport for London’s</span> 
                                reasons for the proposals, a map indicating the location and 
                                effect of the Order and copies of any Order revoked, suspended or varied by the Order can be inspected 
                                during normal office hours at the offices of:

                            <ul class="my-1">
                                <li>
                                    •	<span id="form_step_permanent_s_6_making_streets_traffic_order_text">Transport for London Streets Traffic Order Team (RSM/PI/STOT) Palestra, 197 Blackfriars Road London, SE1 8NJ</span>
                                </li>
                            </ul>
                            
                        </li>

                        <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                Any person wishing to question the validity of the Order or of any of its provisions on the grounds that they are not 
                                within the relevant powers conferred by the Act or that any requirement of the Act has not been complied with, that 
                                person may, within six weeks from the date on which the Order is made, make application for the purpose to the High Court.
                        </li>

                        <p class="my-4 text-lg flex flex-wrap items-center text-gray-800 md:text-xl">
                            <span>Dated this</span>
                            <span id="form_step_permanent_s_6_making_dated_this_text">21st</span>
                            <span>day of</span>
                            <span id="form_step_permanent_s_6_making_month_text">January</span>
                            <span>202</span>
                            <span id="form_step_permanent_s_6_making_year_text">2</span>
                        </p>

<div class="mt-6" id="emergency">
                    <h3 class="mb-2 text-lg text-gray-900 font-bold md:text-xl">Appropriate Person</h3>
                    <div class="mb-2 text-lg text-gray-800 md:text-xl"> 
                        <span class="text-lg text-gray-900 font-bold md:text-xl">
                            <span id="form_step_permanent_s_6_making_person_title_text">Person Title</span>, </span>
                        <span class="font-normal">
                            <span id="form_step_permanent_s_6_making_transport_for_london_2_text">Transport for London</span></span> 
                    </div>
                    <div class="mb-4 text-lg text-gray-800 md:text-xl font-normal">
                        <span id="form_step_permanent_s_6_making_road_london_text">Palestra, 197 Blackfriars Road, London, SE1 8NJ</span>
                    </div>
                </div>
                    
                    </ol>
                </div>
               <button type="button" id="form_step_permanent_s_6_making_submit" data-modal-target="section-6-making-modal" data-modal-toggle="section-6-making-modal"
                    class="text-white bg-black hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>





<!-- Handle the case where no drafts are found for any of the specific order types -->
    @if($specificOrderTypeDrafts14_1->isEmpty() &&
        $emergencyWorkDrafts->isEmpty() &&
        $specificOrderTypeDrafts16_a->isEmpty() &&
        $specificOrderTypeDrafts_section_23->isEmpty() && 
        $specificOrderTypeDrafts14_1->isEmpty() &&
        $emergencyWorkDrafts->isEmpty() &&
        $specificOrderTypeDrafts16_a->isEmpty() &&
        $specificOrderTypeDrafts_section_23->isEmpty())
        <p>No drafts found for the specified order types.</p>
    @endif


@php
    $temporaryOrders = $drafts->filter(fn($draft) => $draft->booking_type == 'Temporary')->pluck('order_type');
    $permanentOrders = $drafts->filter(fn($draft) => $draft->booking_type == 'Permanent')->pluck('order_type');
@endphp

@endsection

@section('scripts')

<script>

    document.getElementById('form_step_permanent_s_6_making_Verify_submit').addEventListener('click', function() {
        const form = document.getElementById('form_step_permanent_s_6_making');
        
        // Retrieve all text elements inside the form except inputs
        let formTextData = [];
        
        form.querySelectorAll('*:not(input):not(button)').forEach(element => {
            // Check if the element has text content and is not empty
            if (element.textContent.trim() !== '') {
                formTextData.push(element.textContent.trim());
            }
        });
        
        // Log the non-input text data
        console.log(formTextData);
    });

        document.getElementById('form_step_permanent_s_6').addEventListener('click', function() {
        const form = document.getElementById('form-step-permanent-s-6_intent');
        
        // Retrieve all text elements inside the form except inputs
        let formTextData = [];
        
        form.querySelectorAll('*:not(input):not(button)').forEach(element => {
            // Check if the element has text content and is not empty
            if (element.textContent.trim() !== '') {
                formTextData.push(element.textContent.trim());
            }
        });
        
        // Log the non-input text data
        console.log(formTextData);
    });



    // Pass data from Blade to JavaScript
    const temporaryOrders                       = @json($temporaryOrders);
    const permanentOrders                       = @json($permanentOrders);

    // Temporary Orders
    const specificOrderTypeDrafts14_1           = @json($specificOrderTypeDrafts14_1->isNotEmpty());
    const emergencyWorkDraftsAvailable          = @json($emergencyWorkDrafts->isNotEmpty());
    const specificOrderTypeDrafts16_a           = @json($specificOrderTypeDrafts16_a->isNotEmpty());
    const specificOrderTypeDrafts_section_23    = @json($specificOrderTypeDrafts_section_23->isNotEmpty());

    // Permanent Orders
    const section_6                             = @json($section_6->isNotEmpty());
    const bannedTurnOrder                       = @json($Banned_Turn_Order->isNotEmpty());
    const prescribedRouteOrder                  = @json($Prescribed_Route_Order->isNotEmpty());
    const busPriorityOrders                     = @json($Bus_Priority_Orders->isNotEmpty());
    const clearwayOrders                        = @json($Clearway_Orders->isNotEmpty());
    const cycleLaneOrder                        = @json($Cycle_Lane_Order->isNotEmpty());
    const cycleTrackNotices                     = @json($Cycle_Track_Notices->isNotEmpty());
    const speedLimit_83_84                      = @json($Speed_Limit_83_84->isNotEmpty());
    const variationOrders                       = @json($Variation_Orders->isNotEmpty());
    const consolidatedOrders                    = @json($Consolidated_Orders->isNotEmpty());
    const parkingControlOrders                  = @json($Parking_Control_Orders->isNotEmpty());
    const priorityTrafficLane                   = @json($Priority_Traffic_Lane->isNotEmpty());
    const section9Experimental                  = @json($Section_9_Experimental->isNotEmpty());
    const section9_6                            = @json($Section_9_6->isNotEmpty());
    const section9_83                           = @json($Section_9_83->isNotEmpty());
    const revocationOrder                       = @json($Revocation_Order->isNotEmpty());
    const modificationOrder                     = @json($Modification_Order->isNotEmpty());
    

    // Get the dropdown elements and the button
    const bookingTypeDropdown                   = document.getElementById('booking_type');
    const orderTypeDropdown                     = document.getElementById('order_type');
    const noticeTypeDropdown                    = document.getElementById('notice_type');
    const contentContainer                      = document.getElementById('content_container');
    const nextButton                            = document.querySelector('.next-step'); // Assuming you have a class 'next-step' for the button

    // Initialize button state
    nextButton.style.display = 'none'; 

    // Function to check if both dropdowns have selected values and show/hide the Next button
    function checkSelection() {
        const selectedBookingType = bookingTypeDropdown.value;
        const selectedOrder = orderTypeDropdown.value;
        const noticeType = noticeTypeDropdown.value;
        
        console.log(`${selectedBookingType}, ${selectedOrder}, ${noticeType}`);

        // Check if both the booking type and notice type have valid selections
        if (selectedBookingType && selectedOrder !== "Select Relevant Order" && noticeType !== "*Select Type of Notice*") {
            // Check specific conditions for selectedOrder and draft availability
            if (
                (selectedOrder === "14 (2) – Emergency Work Order" && emergencyWorkDraftsAvailable) || 
                (selectedOrder === "14 (1) – Full or Partial Road Closure" && specificOrderTypeDrafts14_1)
            ) {
                nextButton.style.display = 'block'; // Show the Next button
            } else {
                nextButton.style.display = 'none'; // Hide the Next button for all other orders
            }
        } else {
            nextButton.style.display = 'none'; // Hide the Next button if selections are not valid
        }
    }


    // Event listener for when 'booking_type' changes
    bookingTypeDropdown.addEventListener('change', function () {
        const selectedBookingType = this.value;
        orderTypeDropdown.innerHTML = '<option disabled selected>Select Relevant Order</option>'; // Reset the order options

        let orders = [];

        if (selectedBookingType === 'temporary') {
            orders = temporaryOrders; // Load Temporary Orders
        } else if (selectedBookingType === 'permanent') {
            orders = permanentOrders; // Load Permanent Orders
        }

        // Populate the order dropdown
        orders.forEach(function (order) {
            const option = document.createElement('option');
            option.value = order;
            option.textContent = order;
            orderTypeDropdown.appendChild(option);
        });

        // Check if both dropdowns have selected values
        checkSelection();
    });

    function displayContentNone() {
        document.getElementById('form_step_permanent_s_6').style.display = "none";
        document.getElementById('form_step_permanent_s_6_making').style.display = "none";
        document.getElementById("emergency").style.display = "none";
    }

    // Event listener for when 'order_type' changes
    orderTypeDropdown.addEventListener('change', function () {
        const selectedOrder = this.value;

        // Display content based on the selected order
        

        if (bookingTypeDropdown.value === 'temporary') {
            // full_partial_road_closure_content
            if (selectedOrder === "14 (1) – Full or Partial Road Closure") {
                displayContentNone();
            }             
            
            else if (selectedOrder === "14 (2) – Emergency Work Order" && emergencyWorkDraftsAvailable) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    console.log(`Notice of Intent: ${emergencyWorkDraftsAvailable}`);
                } else {
                    console.log(`Notice of Making: ${emergencyWorkDraftsAvailable}`);
                }
                document.getElementById('form_step_permanent_s_6').style.display = "none";
                document.getElementById('form_step_permanent_s_6_making').style.display = "none";
                document.getElementById("emergency").style.display = "block";

            } 
            
            
            else if (selectedOrder === "16 (A) – Special Events" && specificOrderTypeDrafts16_a) {
                if (noticeTypeDropdown.value === "Notice of Intent") {
                    console.log(`Notice of Intent: 16 (A) – Special Events`);
                } else {
                    
                    console.log(`Notice of Making: 16 (A) – Special Events`);
                }
                displayContentNone();

            } 


            else if (selectedOrder === "Section 23 Pedestrian Notices" && specificOrderTypeDrafts_section_23) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    console.log(`Notice of Intent: Section 23 Pedestrian Notices`);
                } else {
                    
                console.log(`Notice of Making: Section 23 Pedestrian Notices`);
                }
                displayContentNone();
            }
        } 
        
        
        // Permanent Orders
        else if (bookingTypeDropdown.value === 'permanent') {
            if (selectedOrder === "Section 6" && section_6) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    document.getElementById('form_step_permanent_s_6').style.display = "block";
                    console.log(`Notice of Intent: Section 6`);
                } else {
                    document.getElementById('form_step_permanent_s_6_making').style.display = "block";
                    console.log(`Notice of Making: Section 6`);
                }
                // displayContentNone();
            } 
            
            else if (selectedOrder === "Banned Turn Order" && bannedTurnOrder) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Banned Turn Order`);
                } else {
                    
                    console.log(`Notice of Making: Banned Turn Order`);
                } 
                document.getElementById('form_step_permanent_s_6').style.display = "none";
                document.getElementById('form_step_permanent_s_6_making').style.display = "none";
            }
            
            else if (selectedOrder === "Prescribed Route Order" && prescribedRouteOrder) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Prescribed Route Order`);
                } else {
                    
                    console.log(`Notice of Making: Prescribed Route Order`);
                }   
            document.getElementById('form_step_permanent_s_6').style.display = "none";
            }
            
            else if (selectedOrder === "Bus Priority Orders" && busPriorityOrders) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Bus Priority Orders`);
                } else {
                    
                    console.log(`Notice of Making: Bus Priority Orders`);
                }  
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Clearway Orders" && clearwayOrders) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Clearway Orders`);
                } else {
                    
                    console.log(`Notice of Making: Clearway Orders`);
                }
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Cycle Lane Order" && cycleLaneOrder) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Cycle Lane Order`);
                } else {
                    
                    console.log(`Notice of Making: Cycle Lane Order`);
                } 
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Cycle Track Notices" && cycleTrackNotices) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Cycle Track Notices`);
                } else {
                    
                    console.log(`Notice of Making: Cycle Track Notices`);
                }   
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            } 
            
            else if (selectedOrder === "Speed Limit 83 & 84" && speedLimit_83_84) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Speed Limit 83 & 84`);
                } else {
                    
                    console.log(`Notice of Making: Speed Limit 83 & 84`);
                }  
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Variation Orders" && variationOrders) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Variation Orders`);
                } else {
                    
                    console.log(`Notice of Making: Variation Orders`);
                } 
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Consolidated Orders" && consolidatedOrders) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Consolidated Orders`);
                } else {
                    
                    console.log(`Notice of Making: Consolidated Orders`);
                }  
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Parking Control Orders" && parkingControlOrders) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Parking Control Orders`);
                } else {
                    
                    console.log(`Notice of Making: Parking Control Orders`);
                }  
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Priority Traffic Lane" && priorityTrafficLane) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Priority Traffic Lane`);
                } else {
                    
                    console.log(`Notice of Making: Priority Traffic Lane`);
                }
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Section 9 Experimental" && section9Experimental) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Section 9 Experimental`);
                } else {
                    
                    console.log(`Notice of Making: Section 9 Experimental`);
                }
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Section 9-6" && section9_6) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Section 9-6`);
                } else {
                    
                    console.log(`Notice of Making: Section 9-6`);
                }
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Section 9-83/84" && section9_83) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Section 9-83/84`);
                } else {
                    
                    console.log(`Notice of Making: Section 9-83/84`);
                }   
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Revocation Order" && revocationOrder) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Revocation Order`);
                } else {
                    
                    console.log(`Notice of Making: Revocation Order`);
                }   
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }
            
            else if (selectedOrder === "Modification Order" && modificationOrder) {
                if(noticeTypeDropdown.value === "Notice of Intent") {
                    
                    console.log(`Notice of Intent: Modification Order`);
                } else {
                    
                    console.log(`Notice of Making: Modification Order`);
                }    
            document.getElementById('form_step_permanent_s_6').style.display = "none";

            }

        }

        // Check if both dropdowns have selected values
        checkSelection();
    });

    // Step navigation
    document.querySelectorAll('.next-step-emergency').forEach(button => {
        button.addEventListener('click', () => {
            const currentStep = document.querySelector('.form-step-emergency.active');
            const nextStep = currentStep.nextElementSibling;

            if (nextStep) {
                currentStep.classList.remove('active');
                currentStep.style.display = 'none';
                nextStep.classList.add('active');
                nextStep.style.display = 'block';
            }

            updateStepper();
        });
    });

    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', () => {
            const currentStep = document.querySelector('.form-step.active');
            const nextStep = currentStep.nextElementSibling;

            if (nextStep) {
                currentStep.classList.remove('active');
                currentStep.style.display = 'none';
                nextStep.classList.add('active');
                nextStep.style.display = 'block';
            }

            updateStepper();
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', () => {
            const currentStep = document.querySelector('.form-step.active');
            const prevStep = currentStep.previousElementSibling;

            if (prevStep) {
                currentStep.classList.remove('active');
                currentStep.style.display = 'none';
                prevStep.classList.add('active');
                prevStep.style.display = 'block';
            }

            updateStepper();
        });
    });


    document.querySelectorAll('.prev-step-emergency').forEach(button => {
        button.addEventListener('click', () => {
            const currentStep = document.querySelector('.form-step-emergency.active');
            const prevStep = currentStep.previousElementSibling;

            if (prevStep) {
                currentStep.classList.remove('active');
                currentStep.style.display = 'none';
                prevStep.classList.add('active');
                prevStep.style.display = 'block';
            }

            updateStepper();
        });
    });

    function updateStepper() {
        const steps = document.querySelectorAll('.step');
        const activeIndex = Array.from(document.querySelectorAll('.form-step')).findIndex(step => step.classList.contains('active'));

        steps.forEach((step, index) => {
            const stepNumber = step.querySelector('div');
            const divider = step.querySelector('.flex-1');

            if (index < activeIndex) {
                step.classList.add('text-blue-600', 'dark:text-blue-500');
                step.classList.remove('text-gray-600', 'dark:text-gray-700');
                stepNumber.classList.add('bg-blue-100');
                stepNumber.classList.remove('bg-gray-100');
                stepNumber.classList.add('text-white');
                stepNumber.classList.remove('text-gray-600');
                if (divider) {
                    divider.classList.add('bg-blue-600');
                    divider.classList.remove('bg-gray-200');
                }
            } else if (index === activeIndex) {
                step.classList.add('text-blue-600', 'dark:text-blue-500');
                step.classList.remove('text-gray-600', 'dark:text-gray-700');
                stepNumber.classList.add('bg-blue-600');
                stepNumber.classList.remove('bg-gray-200');
                stepNumber.classList.add('text-white');
                stepNumber.classList.remove('text-gray-600');
                if (divider) {
                    divider.classList.add('bg-blue-600');
                    divider.classList.remove('bg-gray-200');
                }
            } else {
                step.classList.remove('text-blue-600', 'dark:text-blue-500');
                step.classList.add('text-gray-600', 'dark:text-gray-700');
                stepNumber.classList.add('bg-gray-200');
                stepNumber.classList.remove('bg-blue-600');
                stepNumber.classList.add('text-gray-600');
                stepNumber.classList.remove('text-white');
                if (divider) {
                    divider.classList.add('bg-gray-200');
                    divider.classList.remove('bg-blue-600');
                }
            }
        });
    }

    // Get radio buttons and hidden containers for plan upload
    const yesUploadedYourPlan = document.getElementById('yes_uploaded_your_plan');
    const noUploadedYourPlan = document.getElementById('no_uploaded_your_plan');
    const planUploadContainer = document.getElementById('state-container');
    
    // Get radio buttons and hidden section_101_agreement
    const yesSection101Agreement = document.getElementById('yes_section_101_agreement');
    const noSection101Agreement = document.getElementById('no_section_101_agreement');
    const yesBoroughCouncel = document.getElementById('yes_borough_councel');

    // Event listeners for showing/hiding
    yesSection101Agreement.addEventListener('change', function () {
        if (this.checked) {
            yesBoroughCouncel.style.display = 'block';
        }
    });

    noSection101Agreement.addEventListener('change', function () {
        if (this.checked) {
            yesBoroughCouncel.style.display = 'none'; // Hide file upload input
        }
    });



    // Get radio buttons and hidden containers for work permit
    const yesWorkPermit = document.getElementById('yes_work_permit');
    const noWorkPermit = document.getElementById('no_work_permit');
    const permitNumberContainer = document.getElementById('state-container-2');

    // Event listeners for showing/hiding plan upload input
    yesUploadedYourPlan.addEventListener('change', function () {
        if (this.checked) {
            planUploadContainer.style.display = 'flex'; 
        }
    });

    noUploadedYourPlan.addEventListener('change', function () {
        if (this.checked) {
            planUploadContainer.style.display = 'none'; // Hide file upload input
        }
    });

    // Event listeners for showing/hiding permit number input
    yesWorkPermit.addEventListener('change', function () {
        if (this.checked) {
            permitNumberContainer.style.display = 'flex'; // Show permit number input
        }
    });

    noWorkPermit.addEventListener('change', function () {
        if (this.checked) {
            permitNumberContainer.style.display = 'none'; // Hide permit number input
        }
    });

    yesUploadedYourPlan.addEventListener('change', function () {
        if (this.checked) {
            planUploadContainer.style.display = 'flex'; // Show file upload input
        }
    });

    noUploadedYourPlan.addEventListener('change', function () {
        if (this.checked) {
            planUploadContainer.style.display = 'none'; // Hide file upload input
        }
    });


    document.getElementById('submit').addEventListener('click', function() {
        alert("Form submitted successfully!");
        document.getElementById('form').submit();
    });

</script>


<script>
    function resizeIframe() {
        const iframe = document.getElementById('mapFrame');
        iframe.style.width = `${window.innerWidth*0.7}px`;
        iframe.style.height = `${window.innerHeight}px`;
    }

    function populateBoroughsList() {
        const boroughs = [
            "Borough 1",
            "Borough 2",
            "Borough 3",
            "Borough 4",
            "Borough 5"
        ];

        const boroughsList = document.getElementById('boroughsList');
        boroughsList.innerHTML = boroughs.map(borough => `<p class="cursor-pointer hover:bg-gray-200 p-2">${borough}</p>`).join('');
    }

    // Resize iframe on load and when window is resized
    window.addEventListener('load', () => {
        resizeIframe();
        populateBoroughsList();
    });
    window.addEventListener('resize', resizeIframe);
</script>

@endsection
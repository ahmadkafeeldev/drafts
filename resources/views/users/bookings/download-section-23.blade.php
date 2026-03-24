@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
    
    // Parse the effective_at_certain_times date from MySQL
    $effectiveAt = Carbon::parse($booking->effective_at_certain_times);
    $formattedEffectiveAt = $effectiveAt->format('h:i A jS F Y');
    
    $until_time = Carbon::parse($booking->until_time);
    $until_time_formattedEffectiveAt = $until_time->format('h:i A jS F Y');

    

    // Generate a random string of 16 characters
    $randomString = Str::random(16);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Download - Draft</title>
    <meta name="author" content="TfL Street Management" />
    <meta name="created" content="2019-07-12T09:43:00" />
    <meta name="changedby" content="Tariq Mehmood" />
    <meta name="changed" content="2024-10-13T12:51:00" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="Company" content="TfL Street Management" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-gray-50 w-full max-w-6xl text-gray-900 font-sans p-8 rounded-lg">
        <div class="text-center mb-8 flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-blue-900 mb-2">{{ $booking->transport_for }}</h1>
            <p class="text-xl font-semibold">PUBLIC NOTICE</p>
            <p class="text-lg font-bold uppercase">{{ $booking->road }} {{ $booking->date_year }} No. {{ $randomString }}</p>
            <p class="text-lg font-bold uppercase">Road traffic regulation act 1984 - Section 23</p>
            <p class="text-lg font-bold uppercase">Proposed {{ $booking->proposed_installation }} of a {{ $booking->removal_or_installation_of }} crossing on the {{ $booking->crossing_on_the }} {{ $booking->road_at }}</p>
        </div>

        <ul class="list-decimal p-8">
            <li>
                <p class="text-base leading-relaxed">
                    {{ $booking->transport_for }} hereby {{ $booking->notice_type }} that to facilitate pedesterian movements and improve road safety, 
                    it proposes to install a {{ $booking->removal_or_installation_of }} pedesterian crossing over the carriageway of the {{ $booking->carriageway }} {{ $booking->road_at }} {{ $booking->removal_or_installation_of }} crossing at that location. 
                </p>
            </li>
            
            <li>
                <p class="text-base leading-relaxed">
                    Any representations in respect of that proposal should be made in writting and sent to {{ $booking->transport_for }}, {{ $booking->palestra_address }}, {{ $booking->qouting_reference }}, {{ $booking->road_at }} {{ $booking->created_at }}, within {{ $booking->days_from_the_date_of_the_notice }} days
                    from the date of this notice.
                </p>
            </li>
            
            <p class="mt-4">Dated this {{ $booking->date_day }} day of {{ $booking->date_month }} {{ $booking->date_year }}</p>
            
            <p class="mt-4 text-base font-bold">Appropriate Person</p>
                <p class="text-base italic font-bold"><span>{{ $booking->person_title }},</span> <span class="font-normal">{{ $booking->transport_for }}</span></p>
                <p class="text-base">{{ $booking->palestra_address }}</p>
                
            <div>
                <img src="https://drafts.firstpros.net/{{ $booking->signature }}" alt="{{ $booking->transport_for }}" class="h-24 object-cover my-2 bg-blend-multipl" />
            </div>
        </ul>
        
        <!-- Share Button -->
        <div class="mt-4 text-center">
            <button id="shareButton" class="bg-blue-600 text-white py-2 px-4 rounded-lg">Share</button>
        </div>
        
        <script>
            document.getElementById('shareButton').addEventListener('click', async () => {
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: 'Share the Public Notice',
                            text: '{{ $booking->transport_for }} - Public Notice',
                            url: window.location.href
                        });
                    } catch (error) {
                        console.error('Error sharing:', error);
                    }
                } else {
                    alert('Sharing is not supported in this browser.');
                }
            });
        </script>
    </div>
</body>

</html>

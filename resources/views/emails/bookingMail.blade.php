<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Mail</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>

</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-7xl mx-auto my-10 p-6 bg-white rounded-lg">
        <div class="mb-6">
            <img src="https://cdn-icons-png.freepik.com/512/732/732221.png" alt="Logo" class="h-24 object-cover m-auto">
        </div>
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Quotation for {{ $booking->title }}</h1>
            <p class="text-gray-600 mt-2">[Your Company Name]</p>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-800">Dear {{ $user->first_name }} {{ $user->last_name }},</p>
            <p class="text-gray-600 mt-2">
                Thank you for your inquiry about {{ $booking->title }}. We are pleased to provide you with a quotation based on your requirements. Below is the detailed quotation for your review:
            </p>
        </div>
        
        <div class="mb-6">
            <div class="flex justify-between mb-4">
                <p class="font-semibold text-gray-800">Quotation Reference:</p>
                <p class="text-gray-600">{{ random_int(100000, 999999) }}</p>
            </div>
            <div class="flex justify-between mb-4">
                <p class="font-semibold text-gray-800">Date:</p>
                <p class="text-gray-600">{{ $booking->created_at->format('Y-m-d') }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto m-auto w-full">
            <table class="w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-800">
                        <th class="p-3 border-b">ID</th>
                        <th class="p-3 border-b">User ID</th>
                        <th class="p-3 border-b">Newspaper ID</th>
                        <th class="p-3 border-b">Title</th>
                        <th class="p-3 border-b">Area</th>
                        <th class="p-3 border-b">Borough</th>
                        <th class="p-3 border-b">Publish Date</th>
                        <th class="p-3 border-b">Document</th>
                        <th class="p-3 border-b">Price</th>
                        <th class="p-3 border-b">Booking Type</th>
                        <th class="p-3 border-b">Status</th>
                        <th class="p-3 border-b">Created At</th>
                        <th class="p-3 border-b">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-3 border-b">{{ $booking->id }}</td>
                        <td class="p-3 border-b">{{ $user->id }}</td>
                        <td class="p-3 border-b">{{ $booking->news_paper_id }}</td>
                        <td class="p-3 border-b">{{ $booking->title }}</td>
                        <td class="p-3 border-b">{{ $booking->area }}</td>
                        <td class="p-3 border-b">{{ $booking->borough }}</td>
                        <td class="p-3 border-b">{{ $booking->publish_date == null ? 'N/A' : $booking->publish_date }}</td>
                        <td class="p-3 border-b">
                        <a href="{{ asset($booking->document) }}" class="hover:text-blue-500 hover:underline p-2 rounded-lg"
                                                    target="_blank">{{ asset($booking->document) }}</a>
                        </td>
                        <td class="p-3 border-b">{{ $booking->price == null ? 'N/A' : $booking->price }}</td>
                        <td class="p-3 border-b">{{ $booking->booking_type }}</td>
                        <td class="p-3 border-b">{{ $booking->status }}</td>
                        <td class="p-3 border-b">{{ $booking->created_at }}</td>
                        <td class="p-3 border-b">{{ $booking->updated_at }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 mb-6">
            <div class="flex justify-between">
                <p class="font-semibold text-gray-800">Subtotal:</p>
                <p class="text-gray-600">[Subtotal Amount]</p>
            </div>
            <div class="flex justify-between">
                <p class="font-semibold text-gray-800">Tax (X%):</p>
                <p class="text-gray-600">[Tax Amount]</p>
            </div>
            <div class="flex justify-between">
                <p class="font-semibold text-gray-800">Discount (if any):</p>
                <p class="text-gray-600">[Discount Amount]</p>
            </div>
            <div class="flex justify-between font-semibold text-gray-800">
                <p>Total Amount:</p>
                <p>[Total Amount]</p>
            </div>
        </div>
        
        <div class="mb-6">
            <p class="font-semibold text-gray-800">Terms and Conditions:</p>
            <ul class="list-disc list-inside text-gray-600 mt-2">
                <li>The quotation is valid until [Validity Date].</li>
                <li>Payment terms: [Payment Terms].</li>
                <li>Delivery time: [Delivery Timeframe].</li>
                <li>Any other applicable terms.</li>
            </ul>
        </div>
        
        <div>
            <p class="text-gray-600 mt-4">Please review the quotation and let us know if you have any questions or require any further information. We look forward to your response and the opportunity to work with you.</p>
            <p class="text-gray-600 mt-4">Thank you for considering MTechsoft LLC.</p>
            <p class="text-gray-600 mt-4">
                Best regards,<br>
                @if($user->type == auth()->user()->type) 
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}<br>
                    Co-founder<br>
                    MTechsoft LLC<br>
                    {{ auth()->user()->email }}<br>
                @else 
                    [Your Full Name]<br>
                    [Your Position]<br>
                    [Your Company Name]<br>
                    [Your Contact Information]<br>
                    [Your Company Website]
                @endif
                
            </p>
        </div>
    </div>
</section>

</body>
</html>
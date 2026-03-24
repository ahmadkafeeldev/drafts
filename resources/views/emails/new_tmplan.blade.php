<!DOCTYPE html>
<html>
<body>
    <p>Hi dear,</p>
    <p>You Have A New Traffic Management Plan.</p><br>
    <p><b>Traffic Management Plan Details:</b></p>
    <p>Client Name: {{ $user->first_name }} {{ $user->last_name }}</p>
    <p>Client Email: {{ $user->email }}</p>
    <p>Source Location: {{ $plan->source_location }}</p>
    <p>Destination Location: {{ $plan->destination_location }}</p>
    <p>Distance: {{ $plan->total_distance }} {{ $plan->distance_unit }}</p>

    <br />
    <p>Kindly Visit <a href="{{route('home')}}">Admin Panel</a> For More Information.</p>
    <p>Thanks</p>
</body>

</html>

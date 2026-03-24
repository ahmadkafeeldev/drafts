<!DOCTYPE html>
<html>
<body>
    <p>Hi Dear,</p>
    <p>You Have A Draft.</p><br>
    <p><b>Draft Details:</b></p>
    <p>Client Name: {{ $user->first_name }} {{ $user->last_name }}</p>
    <p>Client Email: {{ $user->email }}</p>
    <p></p>
    <p>Kindly Visit <a href="{{route('home')}}">Admin Panel</a> For More Information.</p>
    <p>Thanks</p>
</body>

</html>

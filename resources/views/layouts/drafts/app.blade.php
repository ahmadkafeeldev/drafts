
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.flaticon.com/512/4208/4208375.png">

    @yield('styles')

    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>



     <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        .bg-dark-black {
            background-color: #1a1a1a;
        }

        ul li {
            transition: all 0.3s ease;
        }
        
        /* Sidebar animation */
        .sidebar {
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateX(-100%);
            opacity: 0;
        }

        .sidebar.show {
            transform: translateX(0);
            opacity: 1;
        }

        /* Settings menu animation */
        .settings-menu {
            transition: max-height 0.3s ease, opacity 0.3s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }

        .settings-menu.show {
            max-height: 200px; /* Adjust this value if needed */
            opacity: 1;
        }

        .settings-menu.hidden {
            max-height: 0;
            opacity: 0;
        }

        /* Rotate arrow */
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="flex min-h-screen bg-white">

    <!-- Sidebar -->    
    @include('layouts.drafts.sidebar')

    <!-- Main Content -->
    <div class="flex-1">
        @include('layouts.drafts.topbar')
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>

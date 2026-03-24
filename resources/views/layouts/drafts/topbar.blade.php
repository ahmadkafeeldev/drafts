<!-- Navbar -->
<nav class="sticky top-0 left-0 w-full z-50 bg-[#3B945E] text-white shadow-md p-4 rounded mt-1">
        <div class="container mx-auto flex items-center justify-between gap-2 ">    
    <!-- Search Box -->
        <div class="flex flex-1 max-w-lg mx-auto">
            <input type="text" placeholder="Search..." class="w-full px-4 py-3 rounded-lg border border-slate-600 bg-transparent text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Navbar Items -->
        <div class="flex items-center space-x-4">

            <!-- Notifications Dropdown -->
            <div class="relative">
                <div class="absolute right-0 mt-0 p-1 w-4 h-4 bg-white text-sm text-center text-gray-800 rounded-full shadow-lg z-10"></div>
                <button id="notifications-button" class="flex items-center p-3 rounded-full transition transition-all bg-gray-700 hover:bg-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                    </svg>

                </button>
                
                
                <!-- Notifications Dropdown Menu -->
                <div id="notifications-menu" class="absolute right-0 mt-2 w-72 bg-white text-gray-800 rounded-lg shadow-lg hidden z-10" style="overflow: hidden">
                    <ul>
                        <li class="border-b border-gray-200">
                            <a href="#" class="block px-4 flex py-2 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                </svg>
                                <span>New message from John</span>
                            </a>
                        </li>
                        <li class="border-b border-gray-200">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-user-plus mr-2"></i> New follower
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Settings updated
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profile-button" class="flex items-center p-1 rounded-full hover:bg-gray-700 focus:outline-none border-2 border-white">
                    <img src="{{ asset(Auth::user()->profile_image) }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                </button>
                <!-- Profile Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-lg hidden z-10" style="overflow: hidden">
                    <ul>
                        <li class="border-b border-gray-200">
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                        </li>
                        <li class="border-b border-gray-200">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        </div>
    </nav>


    <script>
        // Notifications dropdown toggle
        const notificationsButton = document.getElementById('notifications-button');
        const notificationsMenu = document.getElementById('notifications-menu');

        notificationsButton.addEventListener('click', () => {
            notificationsMenu.classList.toggle('hidden');
        });

        // Profile dropdown toggle
        const profileButton = document.getElementById('profile-button');
        const profileMenu = document.getElementById('profile-menu');

        profileButton.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        // Close dropdowns if clicking outside
        document.addEventListener('click', (event) => {
            if (!notificationsButton.contains(event.target) && !notificationsMenu.contains(event.target)) {
                notificationsMenu.classList.add('hidden');
            }
            if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    </script>
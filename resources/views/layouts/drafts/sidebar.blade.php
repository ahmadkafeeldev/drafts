<!-- Menu Button for Mobile -->
    <div class="p-4 bg-dark-black text-white shadow-md md:hidden">
        <button id="menu-toggle" class="focus:outline-none w-10 h-10 bg-blue-600 hover:bg-blue-700 text-center flex items-center justify-center rounded-lg">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 6H21M3 12H21M7 18H21" stroke="white" stroke-width="1.6" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <!-- Main Layout with Sidebar -->
<div class="flex min-h-screen">
  <div id="sidebar" class="w-92 bg-[#46344E] h-[160vh] p-4 hidden md:flex flex-col justify-between">
            <div>
                <!-- Logo -->
                <div class="text-center text-white text-2xl font-medium my-4">
                    <a href="#" class="text-white">Traffic Orders Drafting</a>
                </div>

                <!-- divider -->
                <div class="border-b border-gray-700 my-8"></div>

                <!-- Navigation Links -->
                <nav>
                    <ul class="space-y-4">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('user.draft_dashboard') }}" class="flex items-center text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>

                                Status
                            </a>
                        </li>


                        <!-- New Drafts -->
                        <li>
                            <a href="{{route('user.bookings.create')}}" class="flex items-center text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Create New Draft
                            </a>
                        </li>
                        
                        <!-- New Drafts -->
                        <!--<li>-->
                        <!--    <a href="{{route('user.tmplan_create')}}" class="flex items-center text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300">-->
                        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">-->
                        <!--          <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />-->
                        <!--        </svg>-->

                        <!--        Draw TM Plan-->
                        <!--    </a>-->
                        <!--</li>-->
                        
                        

                        <!-- Temporary Drafts with Collapsible Menu -->
<li>
                        <button class="flex items-center w-full text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300 focus:outline-none" id="settings-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                            Temporary Drafts
                            <svg class="ml-auto transform transition-transform" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 10l5 5 5-5" stroke="white" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </button>
                        <ul id="settings-menu" class="ml-6 mt-2 space-y-2 hidden">
                            <li>
                                <a href="{{route('user.temporary_intent')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-600 rounded-full w-2 h-2"></span>
                                    Notice of Intent
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.temporary_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Notice of Making
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.experimental_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Order Type
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Permanent Drafts with Collapsible Menu -->
                    <li>
                        <button class="flex items-center w-full text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300 focus:outline-none" id="settings-toggle-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                            Permanent Drafts
                            <svg class="ml-auto transform transition-transform" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 10l5 5 5-5" stroke="white" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </button>
                        <ul id="settings-menu-2" class="ml-6 mt-2 space-y-2 hidden">
                            <li>
                                <a href="{{route('user.permanent_intent')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-600 rounded-full w-2 h-2"></span>
                                    Notice of Intent
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.permanent_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Notice of Making
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.experimental_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Order Type
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <button class="flex items-center w-full text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300 focus:outline-none" id="settings-toggle-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                            Experimental Drafts
                            <svg class="ml-auto transform transition-transform" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 10l5 5 5-5" stroke="white" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </button>
                        <ul id="settings-menu-3" class="ml-6 mt-2 space-y-2 hidden">
                            <li>
                                <a href="{{route('user.experimental_intent')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-600 rounded-full w-2 h-2"></span>
                                    Notice of Intent
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.experimental_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Notice of Making
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('user.experimental_making')}}" class="flex items-center text-gray-300 py-3 px-4 rounded hover:bg-gray-700 transition duration-300">
                                    <span class="mr-3 bg-slate-400 rounded-full w-2 h-2"></span>
                                    Order Type
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    
                    <li>
                        <a href="{{route('user.bookings.index')}}" class="flex items-center text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                            My All Drafts
                        </a>
                    </li>

                    <!-- TRO GIS Map -->
                    <li>
                        <a href="{{route('user.tro_gis_map')}}" class="flex items-center text-white py-3 px-4 rounded hover:bg-gray-800 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            TRO GIS Map
                        </a>
                    </li>

                    <!-- Logout -->
                        <li>
                            <form action="{{ route('admin-logout') }}" method="POST" class="w-full" style="margin: 0;">
                                @csrf
                                <button type="submit" onclick="return confirm('Do You Really Want to Logout?')" class="flex items-center w-full text-white py-3 px-4 rounded-lg hover:bg-gray-800 transition duration-300 text-left focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-3">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>

                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Profile Info -->
            <div class="flex items-center text-white px-4 py-3 border-t border-gray-700">
                <img src="{{ asset(Auth::user()->profile_image) }}" class="rounded-full w-10 h-10 mr-3" alt="User Avatar">
                <div>
                    <h3 class="font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                    <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Menu toggle functionality
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('hidden');
        });

        // Settings menu toggle functionality
        const settingsToggle = document.getElementById('settings-toggle');
        const settingsToggle2 = document.getElementById('settings-toggle-2');
        const settingsToggle3 = document.getElementById('settings-toggle-3');
        const settingsMenu = document.getElementById('settings-menu');
        const settingsMenu2 = document.getElementById('settings-menu-2');
        const settingsMenu3 = document.getElementById('settings-menu-3');

        settingsToggle.addEventListener('click', function() {
            settingsMenu.classList.toggle('hidden');
            const isOpen = !settingsMenu.classList.contains('hidden');
            settingsToggle.querySelector('svg').classList.toggle('rotate-180', isOpen);
        });
        
        settingsToggle2.addEventListener('click', function() {
            settingsMenu2.classList.toggle('hidden');
            const isOpen = !settingsMenu2.classList.contains('hidden');
            settingsToggle2.querySelector('svg').classList.toggle('rotate-180', isOpen);
        });
        
        settingsToggle3.addEventListener('click', function() {
            settingsMenu3.classList.toggle('hidden');
            const isOpen = !settingsMenu3.classList.contains('hidden');
            settingsToggle3.querySelector('svg').classList.toggle('rotate-180', isOpen);
        });
        
        // Sidebar toggle functionality
       document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const settingsToggle = document.getElementById('settings-toggle');
    const settingsToggle2 = document.getElementById('settings-toggle-2');
    const settingsToggle3 = document.getElementById('settings-toggle-3');
    const settingsMenu = document.getElementById('settings-menu');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('translate-x-0');
        sidebar.classList.toggle('-translate-x-full');

        // Absolute positioning
        sidebar.classList.add('absolute');
        sidebar.classList.add('z-10');

        sidebar.classList.remove('relative');
        sidebar.classList.remove('z-0');

        e.stopPropagation(); 
    });

    settingsToggle.addEventListener('click', () => {
        settingsMenu.classList.toggle('scale-y-100');
        settingsMenu.classList.toggle('scale-y-0');
    });
});




    </script>
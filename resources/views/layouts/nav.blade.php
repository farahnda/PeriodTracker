<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
    <title>PeriodTracker</title>
</head>
<body class="h-full" style="background: linear-gradient(135deg, #D5B0BB 0%, #857DA5 50%, #354A90 100%);">

<div class="min-h-screen">
  <nav class="backdrop-blur-md bg-gray-800/50 fixed top-0 left-0 right-0 z-10 shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div style="font-family: 'Cinzel', serif;" class="shrink-0 rounded-md px-3 py-2 text-sm text-white hover:bg-purple-300 hover:text-grey-300">PeriodTracker</div>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300 hover:text-grey-300">Home</a>
              <a href="/calendar" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300 hover:text-grey-300">Calendar</a>
              <a href="/histories" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300 hover:text-grey-300">History</a>
              <a href="/articles" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300 hover:text-grey-300">Article</a>
            </div>
          </div>
        </div>

        <!-- Bagian kanan navbar -->
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            @auth
              <!-- Notifikasi -->
              <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-grey-300 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">View notifications</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                </svg>
              </button>

              <!-- Dropdown profil -->
              <div class="relative ml-3">
                <div>
                  <button id="user-menu-button" type="button" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <img class="size-8 rounded-full" src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1114445501.jpg" alt="">
                  </button>
                </div>
                <div class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5" role="menu">
                  <a href="/profiles/{{ Auth::id() }}" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700">Sign out</button>
                  </form>
                </div>
              </div>
            @endauth

            @guest
              <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300">Login</a>
              <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300">Register</a>
            @endguest
          </div>
        </div>

        <!-- Tombol menu mobile -->
        <div class="-mr-2 flex md:hidden">
          <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-purple-300 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
            <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5..." />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Menu mobile -->
    <div class="md:hidden hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        <a href="/" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Home</a>
        <a href="/calendar" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Calendar</a>
        <a href="/histories" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">History</a>
        <a href="/articles" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Article</a>
      </div>
      <div class="border-t border-gray-300 pt-4 pb-3">
        @auth
        <div class="flex items-center px-5">
          <img class="size-8 rounded-full" src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1114445501.jpg" alt="">
          <div class="ml-3">
            <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
            <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
          </div>
        </div>
        <div class="mt-3 space-y-1 px-2">
          <a href="/profiles/{{ Auth::id() }}" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Your Profile</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Sign out</button>
          </form>
        </div>
        @endauth

        @guest
        <div class="px-3">
          <a href="{{ route('login') }}" class="block mt-3 rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-300">Login</a>
          <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-purple-300">Register</a>
        </div>
        @endguest
      </div>
    </div>
  </nav>

  <!-- Konten utama -->
  <main class="pt-20">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      @yield('content')
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userMenuBtn = document.getElementById('user-menu-button');
    const userMenu = userMenuBtn?.parentElement?.nextElementSibling;

    if (userMenuBtn && userMenu) {
        userMenu.classList.add('hidden');
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', function (e) {
            if (!userMenu.contains(e.target) && e.target !== userMenuBtn) {
                userMenu.classList.add('hidden');
            }
        });
    }

    const mobileMenuBtn = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>

</body>
</html>

<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="ms-3 mt-2 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden">
  <span class="sr-only">Open sidebar</span>
  <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
  </svg>
</button>

<aside id="default-sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full transition-transform sm:translate-x-0" aria-label="Sidebar">
  <div class="h-full overflow-y-auto bg-gray-50 px-3 py-4">
      <div class="mb-4 flex items-center gap-x-4 px-2">
          {{-- <img src="https://flowbite.com/application-ui/demo/images/logo.svg" alt=""> --}}
          <h2 class="text-xl font-bold">Halo Caleg</h2>
      </div>
      <ul class="space-y-2 font-medium">
          <li>
              <a href="{{ route('dashboard.admin.dashboard') }}" class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100">
                  <i class='bx bx-pie-chart-alt-2 text-3xl text-[#6b7280]'></i>
                  <span class="ms-3">Dashboard</span>
              </a>
          </li>
          <li>
              <a href="{{ route('dashboard.relawan.index') }}" class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100">
                  <i class='bx bx-user-circle text-3xl text-[#6b7280]'></i>
                  <span class="ms-3 flex-1 whitespace-nowrap">Pendukung</span>
              </a>
          </li>
      </ul>
  </div>
</aside>

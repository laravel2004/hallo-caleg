<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="ms-3 mt-2 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden">
    <span class="sr-only">Open sidebar</span>
    <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="default-sidebar" class="fixed left-0 top-0 z-40 h-full w-64 -translate-x-full transition-transform sm:translate-x-0" aria-label="Sidebar">
    <div class="flex h-full flex-col justify-between overflow-y-auto border-r border-neutral-200 bg-gray-50 px-3 py-4">
        <div>
            <div class="mb-4 flex items-center gap-x-4 px-2">
                <h2 class="text-xl font-bold">Halo Caleg</h2>
            </div>
            <div class="flex flex-col justify-between">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="@if (Auth::user()->role == 0) {{ route('dashboard.admin') }} @else {{ route('dashboard.relawan') }} @endif " class="{{ request()->is('dashboard/admin') || request()->is('dashboard/relawan') ? 'bg-gray-200' : 'hover:bg-gray-200' }} group flex items-center rounded-lg p-2 transition-colors duration-200">
                            <i class='bx bx-pie-chart-alt-2 text-3xl text-[#6b7280]'></i>
                            <span class="ms-3 text-gray-900">Dashboard</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 0)
                        <li>
                            <a href="{{ route('dashboard.admin.index') }}" class="{{ request()->is('dashboard/admin/relawan*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} group flex items-center rounded-lg p-2 transition-colors duration-200">
                                <i class='bx bx-user-circle text-3xl text-[#6b7280]'></i>
                                <span class="ms-3 text-gray-900">Relawan</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="@if (Auth::user()->role == 0) {{ route('dashboard.admin.pendukung') }} @else {{ route('dashboard.relawan.pendukung') }} @endif" class="{{ request()->is('dashboard/admin/pendukung*') || request()->is('dashboard/relawan/pendukung*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} group flex items-center rounded-lg p-2 transition-colors duration-200">
                            <i class='bx bx-user-circle text-3xl text-[#6b7280]'></i>
                            <span class="ms-3">Pendukung</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 0)
                        <li>
                            <a href="{{ route('dashboard.candidate.index') }}" class="{{ request()->is('dashboard/admin/candidate*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} group flex items-center rounded-lg p-2 transition-colors duration-200">
                                <i class='bx bx-user-circle text-3xl text-[#6b7280]'></i>
                                <span class="ms-3 text-gray-900">Kandidat</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role == 1)
                        <li>
                            <a href="{{ route('dashboard.quickcount.index') }}" class="{{ request()->is('dashboard/relawan/quickcount*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} group flex items-center rounded-lg p-2 transition-colors duration-200">
                                <i class='bx bx-user-circle text-3xl text-[#6b7280]'></i>
                                <span class="ms-3 text-gray-900">Quickcount</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <a href="{{ route('auth.logout') }}" class="rounded-lg bg-red-600 px-5 py-2.5 text-center text-white transition-colors duration-300 hover:bg-red-700 focus:outline-none">Logout</a>
    </div>
</aside>

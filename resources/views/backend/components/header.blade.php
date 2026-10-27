 <div class="navbar-header shadow-1">
     <div class="row align-items-center justify-content-between">
         <div class="col-auto">
             <div class="d-flex flex-wrap align-items-center gap-4">
                 <button type="button" class="sidebar-mobile-toggle" aria-label="Sidebar Mobile Toggler Button">
                     <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                 </button>
                 <form class="navbar-search">
                     <input type="text" class="bg-transparent" name="search" placeholder="Search">
                     <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                 </form>
             </div>
         </div>
         <div class="col-auto">
             <div class="d-flex flex-wrap align-items-center gap-3">
                 <button type="button" data-theme-toggle
                     class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                     aria-label="Dark & Light Mode Button"></button>


                 <div class="dropdown">

                     <div class="dropdown">
                         <button
                             class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center position-relative"
                             type="button" data-bs-toggle="dropdown">
                             <img src="{{ url('images/thumbs/leave-request-img2.png') }}" alt="Thumbnail"
                                 class="w-40-px h-40-px rounded-circle object-fit-cover flex-shrink-0">

                         </button>
                         <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                             <div
                                 class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                 <div>

                                     <span class="h6 mb-0 text-md d-block text-primary-light">
                                         {{ auth()->user()->name ?? 'Administrator' }}
                                     </span>


                                     <span class="text-secondary-light text-sm mb-0 d-block">
                                         {{ auth()->user()->role ?? 'Super Admin' }}

                                     </span>
                                 </div>
                             </div>

                             <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">


                                 <form method="POST" action="{{ route('logout') }}">
                                     @csrf
                                     <button type="submit"
                                         class="dropdown-item rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-2 py-6">
                                         <i class="ri-shut-down-line"></i>
                                         Log Out
                                     </button>
                                 </form>


                             </div>
                         </div><!-- Notification dropdown end -->

                     </div>
                 </div>
             </div>
         </div>

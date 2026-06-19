
                        
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-100 leading-tight">
            {{ __('Job Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-[#09090b] border border-white/10 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-6 sm:p-8">
                    
                    <!-- Welcome & Controls Header -->
                    <div class="mb-8 border-b border-zinc-800/50 pb-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Welcome, {{ Auth::user()->name ?? 'Yahya' }}</h3>
                        
                        <form method="GET" action="{{ route('dashboard') }}" id="filter-form" class="w-full">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <!-- Search Bar -->
                                <div class="relative w-full sm:max-w-md">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-4 py-2.5 border border-zinc-800 rounded-lg leading-5 bg-zinc-900/50 text-zinc-300 placeholder-zinc-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors" placeholder="Search jobs...">
                                </div>

                                <!-- Filter Dropdown -->
                                <div class="relative shrink-0 w-full sm:w-48 mt-3 sm:mt-0">
                                    <select name="type" onchange="document.getElementById('filter-form').submit()" class="block w-full pl-4 pr-10 py-2.5 text-sm font-medium text-zinc-200 bg-[#09090b] border border-zinc-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm appearance-none cursor-pointer hover:border-zinc-500">
                                       <option value="all_types" {{ request('type', 'all_types') == 'all_types' ? 'selected' : '' }}>All Types</option>
                                       <option value="Full-Time" {{ request('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                       <option value="Part-Time" {{ request('type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                       <option value="Hybrid" {{ request('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                       <option value="Remote" {{ request('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Job List -->
                    <div class="divide-y divide-zinc-800/60">
                        
                    @foreach($jobs as $job)
                    <!-- Job Item -->
                        <div class="py-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group hover:bg-zinc-900/30 transition-colors -mx-6 px-6 rounded-xl cursor-pointer">
                            <div>
                                <h4 class="text-lg font-semibold text-blue-500 group-hover:text-blue-400 transition-colors"><a href="{{ route('job_vacancy.show', $job->id) }}">{{ $job->title }}</a></h4>
                                <p class="text-sm text-zinc-200 mt-1">{{ $job->company->name }} - {{ $job->location }}</p>
                                <div class="flex items-center gap-2 mt-2 text-xs text-zinc-500">
                                    <p>{{ '$'. number_format($job->salary) .  '/year' }}</p>
                                </div>
                            </div>
                            <div class="shrink-0 sm:self-start mt-2 sm:mt-0">
                                <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white shadow-sm shadow-blue-900/20">
                                    {{ $job->type }}
                                </span>
                            </div>
                        </div>
                    @endforeach


                        

                    </div>
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Add custom scrollbar hiding for the filter buttons on mobile -->
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>

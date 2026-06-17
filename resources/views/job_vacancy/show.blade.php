<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-100 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Container -->
            <div class="bg-[#09090b] border border-white/10 rounded-2xl overflow-hidden shadow-2xl p-6 sm:p-10">
                
                <!-- Back Link -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-400 font-medium flex items-center gap-2 transition-colors inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to Jobs
                    </a>
                </div>

                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 border-b border-zinc-800/50 pb-8 mb-8">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">{{ $job->job_category->name }}</h1>
                        <p class="text-lg text-zinc-300 mb-2">{{ $job->company->name }}</p>
                        <div class="flex items-center gap-2 text-zinc-400">
                            <span>{{ $job->location }}</span>
                            <span>&bull;</span>
                            <span class="font-medium text-zinc-300">{{'$'. number_format($job->salary) }}</span>
                        </div>
                    </div>
                    <div class="shrink-0 mt-4 md:mt-0">
                        <a  href="{{ route('job_vacancy.apply', $job->id) }}"class="w-full md:w-auto px-8 py-3 rounded-lg font-bold text-white bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-400 hover:to-rose-400 transition-all shadow-lg shadow-rose-500/25">
                            Apply Now
                        </a>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- Left Column: Job Description -->
                    <div class="lg:col-span-2">
                        <h3 class="text-xl font-bold text-white mb-4">Job Description</h3>
                        <div class="prose prose-invert max-w-none text-zinc-300 leading-relaxed">
                            <p>{{ $job->description }}</p>
                        </div>
                    </div>

                    <!-- Right Column: Job Overview -->
                    <div class="lg:col-span-1">
                        <h3 class="text-xl font-bold text-white mb-4">Job Overview</h3>
                        <div class="bg-zinc-900/80 border border-zinc-800 rounded-xl p-6">
                            <ul class="space-y-6">
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Published Date</p>
                                    <p class="font-medium text-zinc-200">{{ $job->created_at->format('M d, Y') }}</p>
                                </li>
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Company</p>
                                    <p class="font-medium text-zinc-200">{{ $job->company->name }}</p>
                                </li>
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Location</p>
                                    <p class="font-medium text-zinc-200">{{ $job->location }}</p>
                                </li>
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Salary</p>
                                    <p class="font-medium text-zinc-200">{{ '$'. number_format($job->salary) }}</p>
                                </li>
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Type</p>
                                    <p class="font-medium text-zinc-200">{{ $job->type }}</p>
                                </li>
                                <li>
                                    <p class="text-sm text-zinc-500 mb-1">Category</p>
                                    <p class="font-medium text-zinc-200">{{ $job->job_category->name }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

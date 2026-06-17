<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-100 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($applications as $application)
                    @php
                        $job =  $application->job_vacancy;
                        $resume = $application->resume;
                    @endphp
                    <!-- Application Card -->
                    <div class="bg-[#18181b] border border-white/5 rounded-2xl overflow-hidden shadow-xl hover:border-white/10 transition-colors duration-300">
                        <div class="p-6 sm:p-8">
                            
                            <!-- Header Section -->
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-100 mb-1">
                                        {{ $job->title ?? 'Unknown Job Title' }}
                                    </h3>
                                    <p class="text-sm font-medium text-zinc-300">
                                        {{ optional($job->company)->name ?? 'Unknown Company' }}
                                    </p>
                                    <p class="text-xs text-zinc-500 mt-1">
                                        {{ $job->location ?? 'Unknown Location' }}
                                    </p>
                                    <p class="text-xs text-zinc-500 mt-1">
                                        {{ $application->created_at->format('d M Y') }}
                                    </p>
                                    
                                    <div class="mt-4 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
                                        <span class="text-zinc-100 font-semibold">Applied With:</span>
                                        <span class="font-medium text-zinc-200">{{ $resume->file_name ?? 'Resume Document' }}</span>
                                        @if($resume && $resume->file_url)
                                            <a href="{{ $resume->file_url }}" target="_blank" class="text-sky-400 hover:text-sky-300 text-sm font-medium underline decoration-sky-400/30 underline-offset-4 transition-colors">View Resume</a>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="shrink-0 mt-2 sm:mt-0">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-lg text-sm font-medium bg-sky-400 text-sky-950 shadow-sm shadow-sky-900/20">
                                        {{ $job->type ?? 'Full-Time' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body Section -->
                            <div class="pt-6 space-y-4">
                                <div class="flex items-center gap-3">
                                    <!-- Status Pill -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium 
                                        {{ $application->status === 'pending' ? 'bg-amber-400 text-amber-950' : 
                                          ($application->status === 'accepted' ? 'bg-emerald-400 text-emerald-950' : 
                                          ($application->status === 'rejected' ? 'bg-red-400 text-red-950' : 'bg-zinc-600 text-zinc-100')) }}">
                                        Status: {{ strtolower($application->status) }}
                                    </span>
                                    
                                    <!-- Score Pill -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-sky-400 text-sky-950 shadow-sm">
                                        Score: {{ $application->ai_generated_score ?? '0' }}
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <h4 class="text-base font-bold text-zinc-100 mb-2">AI Feedback:</h4>
                                    <p class="text-sm text-zinc-300 leading-relaxed text-justify">
                                        {{ $application->ai_generated_feedback ?? 'No AI feedback was generated for this application.' }}
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                @empty
                    <div class="bg-[#18181b] border border-white/5 rounded-2xl p-12 text-center shadow-xl">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-800/50 mb-4">
                            <svg class="w-8 h-8 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-zinc-200">No applications yet</h3>
                        <p class="text-sm text-zinc-400 mt-2">You haven't submitted any job applications yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-zinc-900 transition-all">
                                Browse Available Jobs
                            </a>
                        </div>
                    </div>
                @endforelse
                
                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="mt-8">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

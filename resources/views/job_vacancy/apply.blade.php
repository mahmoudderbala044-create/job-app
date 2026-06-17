<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-100 leading-tight">
            {{ $job->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#09090b] border border-white/10 rounded-2xl overflow-hidden shadow-2xl p-6 sm:p-10">

                <!-- Back -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}"
                        class="text-blue-500 hover:text-blue-400 font-medium inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Jobs
                    </a>
                </div>

                <!-- Job Header -->
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 border-b border-zinc-800/50 pb-8 mb-8">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">{{ $job->job_category->name }}</h1>
                        <p class="text-lg text-zinc-300 mb-2">{{ $job->company->name }}</p>
                        <div class="flex items-center gap-2 text-zinc-400">
                            <span>{{ $job->location }}</span>
                            <span>&bull;</span>
                            <span class="font-medium text-zinc-300">{{'$' . number_format($job->salary) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Success --}}
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30">
                        <p class="text-red-400 font-semibold mb-2">يرجى تصحيح الأخطاء التالية:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-300 text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('job_vacancy.processApply', $job->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <h3 class="text-xl font-semibold text-white mb-5">Choose Your Resume</h3>

                    {{-- ── Tabs ─────────────────────────────────────────────────────────── --}}
                    <div class="flex gap-2 mb-6 p-1 bg-zinc-900 rounded-xl w-fit border border-zinc-800">
                        <button type="button" id="tab-existing"
                            onclick="switchTab('existing')"
                            class="tab-btn px-5 py-2 rounded-lg text-sm font-medium transition-all bg-zinc-700 text-white">
                            📋 اختر من الموجود
                        </button>
                        <button type="button" id="tab-upload"
                            onclick="switchTab('upload')"
                            class="tab-btn px-5 py-2 rounded-lg text-sm font-medium transition-all text-zinc-400 hover:text-zinc-200">
                            ⬆️ ارفع ملف جديد
                        </button>
                    </div>

                    {{-- ── Tab 1: اختيار من الموجود ─────────────────────────────────────── --}}
                    <div id="panel-existing">
                        @if ($resumes->isEmpty())
                            <div class="p-6 rounded-xl border border-zinc-700 text-center">
                                <p class="text-zinc-400">لا توجد سيرة ذاتية محفوظة بعد.</p>
                                <p class="text-zinc-500 text-sm mt-1">ارفع ملفاً جديداً من التبويب الثاني.</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach ($resumes as $resume)
                                    <label for="resume_{{ $resume->id }}"
                                        class="resume-card flex items-center gap-4 p-4 rounded-xl border cursor-pointer transition-all
                                               {{ old('resume_id') == $resume->id ? 'border-blue-500 bg-blue-500/10' : 'border-zinc-700 hover:border-zinc-500 hover:bg-zinc-800/50' }}">

                                        <input type="radio"
                                            name="resume_id"
                                            id="resume_{{ $resume->id }}"
                                            value="{{ $resume->id }}"
                                            class="w-4 h-4 text-blue-500 bg-zinc-900 border-zinc-600 focus:ring-blue-500 focus:ring-offset-zinc-900"
                                            {{ old('resume_id') == $resume->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                            onchange="onResumeSelect(this)">

                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-zinc-200 truncate">
                                                {{ $resume->file_name ?? 'سيرة ذاتية ' . $loop->iteration }}
                                            </div>
                                            <div class="text-sm text-zinc-500 mt-0.5 truncate">
                                                {{ \Str::limit($resume->summary ?? '', 60) ?: 'لا يوجد ملخص' }}
                                            </div>
                                        </div>

                                        {{-- PDF Icon --}}
                                        <svg class="w-8 h-8 flex-shrink-0 text-red-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zM9 13h1v3H9v-3zm2.5 0H13c.6 0 1 .4 1 1v1c0 .6-.4 1-1 1h-.5v1h-1v-4zm1 .9v1.2H13v-1.2h-.5zm2-.9h1.5v1h-1.5v.7H16v1h-1.5v1h-1v-3.7H14z"/>
                                        </svg>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @error('resume_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ── Tab 2: رفع ملف جديد ─────────────────────────────────────────── --}}
                    <div id="panel-upload" class="hidden">

                        {{-- Drop Zone --}}
                        <div class="relative group">
                            <input type="file"
                                name="resume_file"
                                id="resume_file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                accept=".pdf"
                                onchange="onFileSelect(this)">

                            <div id="drop-zone"
                                class="border-2 border-dashed rounded-xl p-10 text-center transition-all bg-zinc-900/50
                                       {{ $errors->has('resume_file') ? 'border-red-500 bg-red-500/5' : 'border-zinc-600 group-hover:border-blue-500 group-hover:bg-zinc-800/30' }}">

                                <svg id="upload-icon" class="mx-auto h-10 w-10 mb-3 transition-colors {{ $errors->has('resume_file') ? 'text-red-400' : 'text-zinc-500 group-hover:text-blue-400' }}"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>

                                <p id="file-label" class="font-medium text-zinc-300 mb-1">اسحب ملف PDF هنا أو اضغط للاختيار</p>
                                <p class="text-sm text-zinc-500">PDF فقط · الحد الأقصى 5MB</p>
                            </div>
                        </div>

                        {{-- File Preview (hidden by default) --}}
                        <div id="file-preview" class="hidden mt-3 items-center gap-3 p-3 bg-zinc-800/50 rounded-xl border border-zinc-700">
                            <svg class="w-8 h-8 text-red-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p id="preview-name" class="text-zinc-200 font-medium text-sm truncate"></p>
                                <p id="preview-size" class="text-zinc-500 text-xs"></p>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-zinc-500 hover:text-red-400 transition-colors text-xs">✕ إزالة</button>
                        </div>

                        @error('resume_file')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="mt-8">
                        <button type="submit"
                            class="w-full py-4 rounded-xl font-bold text-white bg-gradient-to-r from-blue-500 to-rose-500
                                   hover:from-blue-400 hover:to-rose-400 transition-all shadow-lg shadow-rose-500/25 text-lg">
                            Apply Now
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // ── Tab switching ────────────────────────────────────────────────────────
        function switchTab(tab) {
            const isExisting = tab === 'existing';

            document.getElementById('panel-existing').classList.toggle('hidden', !isExisting);
            document.getElementById('panel-upload').classList.toggle('hidden', isExisting);

            document.getElementById('tab-existing').classList.toggle('bg-zinc-700', isExisting);
            document.getElementById('tab-existing').classList.toggle('text-white', isExisting);
            document.getElementById('tab-existing').classList.toggle('text-zinc-400', !isExisting);

            document.getElementById('tab-upload').classList.toggle('bg-zinc-700', !isExisting);
            document.getElementById('tab-upload').classList.toggle('text-white', !isExisting);
            document.getElementById('tab-upload').classList.toggle('text-zinc-400', isExisting);

            // لو راح لـ upload نشيل اختيار الـ radio
            if (!isExisting) {
                document.querySelectorAll('input[name="resume_id"]').forEach(r => r.checked = false);
            }
        }

        // ── Resume card highlight ────────────────────────────────────────────────
        function onResumeSelect(radio) {
            document.querySelectorAll('.resume-card').forEach(card => {
                card.classList.remove('border-blue-500', 'bg-blue-500/10');
                card.classList.add('border-zinc-700');
            });
            radio.closest('label').classList.add('border-blue-500', 'bg-blue-500/10');
            radio.closest('label').classList.remove('border-zinc-700');
        }

        // ── File selected ────────────────────────────────────────────────────────
        function onFileSelect(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);

            document.getElementById('file-label').textContent = 'تم اختيار الملف ✓';
            document.getElementById('preview-name').textContent = file.name;
            document.getElementById('preview-size').textContent = sizeMB + ' MB';
            document.getElementById('file-preview').classList.remove('hidden');
            document.getElementById('file-preview').classList.add('flex');

            const zone = document.getElementById('drop-zone');
            zone.classList.add('border-green-500', 'bg-green-500/5');
            zone.classList.remove('border-zinc-600', 'border-red-500');
        }

        // ── Clear file ────────────────────────────────────────────────────────────
        function clearFile() {
            document.getElementById('resume_file').value = '';
            document.getElementById('file-label').textContent = 'اسحب ملف PDF هنا أو اضغط للاختيار';
            document.getElementById('file-preview').classList.add('hidden');
            document.getElementById('file-preview').classList.remove('flex');

            const zone = document.getElementById('drop-zone');
            zone.classList.remove('border-green-500', 'bg-green-500/5');
            zone.classList.add('border-zinc-600');
        }

        // ── Auto-switch tab if there was an upload error ─────────────────────────
        @if($errors->has('resume_file'))
            switchTab('upload');
        @endif
    </script>
</x-app-layout>
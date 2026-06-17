<?php

namespace App\Http\Controllers;

use App\Models\Job_Vacancy;
use App\Models\Resume;
use App\Models\Job_Application;
use App\Http\Requests\StoreApplyRequest;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use App\Http\serveise\generateai;

class Job_vacancyController extends Controller
{
    public function show(string $id)
    {
        $job = Job_Vacancy::findOrFail($id);
        return view('job_vacancy.show', compact('job'));
    }

    public function apply(string $id)
    {
        $job     = Job_Vacancy::findOrFail($id);
        $resumes = Resume::where('user_id', auth()->id())->get();

        return view('job_vacancy.apply', compact('job', 'resumes'));
    }

    public function processApply(StoreApplyRequest $request, string $id, generateai $generateai)
    {
        $job = Job_Vacancy::findOrFail($id);

        $alreadyApplied = Job_Application::where('job_vacancy_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()->withErrors(['resume_file' => 'لقد قدّمت على هذه الوظيفة من قبل.']);
        }

        $resumeId = $request->resume_id;

        // 1. معالجة السيرة الذاتية (جديدة أو موجودة مسبقاً)
        if ($request->hasFile('resume_file')) {
            $file     = $request->file('resume_file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'resumes/' . $file->hashName();
            
            Storage::disk('public')->put($filePath, fopen($file->getPathname(), 'r'));

            // قراءة الـ PDF واستخراج النص منه
            $parser = new Parser();
            $text   = $parser->parseFile(storage_path('app/public/' . $filePath))->getText();

            // إرسال النص للسيرفيس لاستخراج البيانات بالذكاء الاصطناعي
            $data = $generateai->extractResumeData($text);

            if ($data instanceof \Illuminate\Http\RedirectResponse) {
                return $data;
            }

            $resume = Resume::create([
                'file_name'      => $fileName,
                'file_url'       => Storage::disk('public')->url($filePath),
                'user_id'        => auth()->id(),
                'contact_detail' => $data['contact_detail'] ?? '',
                'summary'        => $data['summary'] ?? '',
                'skills'         => $data['skills'] ?? '',
                'educations'     => $data['educations'] ?? '',
                'experiences'    => $data['experiences'] ?? '',
            ]);

            $resumeId = $resume->id;
        } else {
            $resume = Resume::findOrFail($resumeId);
            $data = [
                'summary'        => $resume->summary,
                'skills'         => $resume->skills,
                'contact_detail' => $resume->contact_detail,
                'educations'     => $resume->educations,
                'experiences'    => $resume->experiences,
            ];
        }

        // 2. التقييم النهائي لمدى مناسبة السيرة للوظيفة
        $evaluate = $generateai->generate($data, $job);

        if ($evaluate instanceof \Illuminate\Http\RedirectResponse) {
            return $evaluate;
        }

        // 3. حفظ التقديم
        Job_Application::create([
            'job_vacancy_id'        => $job->id,
            'user_id'               => auth()->id(),
            'resume_id'             => $resumeId,
            'status'                => 'pending',
            'ai_generated_score'    => $evaluate['ai_generated_score'] ?? 0,
            'ai_generated_feedback' => $evaluate['ai_generated_feedback'] ?? '',
        ]);

        return redirect()->route('dashboard')->with('success', 'تم إرسال طلبك بنجاح! سيتم التواصل معك قريباً.');
    }
}
<?php

namespace App\Http\serveise;

use OpenAI\Laravel\Facades\OpenAI;

class generateai
{
    // دالة استخراج بيانات السيرة الذاتية (من الـ PDF إلى JSON)
    public function extractResumeData(string $text)
    {
        try {
            $response = OpenAI::chat()->create([
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a precise resume parser. Extract information exactly as it appears in the resume without adding any interpretation or additional context.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Parse the following resume content and extract the information as a JSON Object with the exact keys: 'summary', 'skills', 'contact_detail', 'educations', 'experiences'.\n\nAll values must be plain text strings, not arrays or objects.\n- skills: comma-separated list\n- experiences: each experience on a new line formatted as 'Title at Company (Location) - responsibilities'\n- educations: each education on a new line formatted as 'Degree in Field (Year)'\n- contact_detail: all contact info in one line\n- summary: brief paragraph\n\nResume:\n\n$text"
                    ]
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.1,
            ]);

            return json_decode($response->choices[0]->message->content, true);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['resume_file' => 'حدث خطأ أثناء استخراج بيانات السيرة الذاتية.']);
        }
    }

    // دالة تقييم توافق السيرة الذاتية مع متطلبات الوظيفة
    public function generate($data, $job)
    {
        try {
            $jobcontent = json_encode([
                "job-title"         => $job->title,
                "job-description"   => $job->description,
                "job-skills"        => $job->required_skills,
                "job-salary"        => $job->salary,
                "job-type"          => $job->type,
                "job-location"      => $job->location,
            ]);

            $reusmecontent = json_encode($data);

            $response = OpenAI::chat()->create([
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert HR professional and job recruiter. You are given a job vacancy and a resume.
                        Your task is to analyze the resume and determine if the candidate is a good fit for the job.
                        The output should be in JSON format.
                        Provide a score from 0 to 100 for the candidate's suitability for the job, and a detailed feedback.
                        Response should only be Json that has the following keys: 'ai_generated_score', 'ai_generated_feedback'.
                        Aigenerate feedback should be detailed and specific to the job and the candidate's resume."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Please evaluate this job application. Job Details: {$jobcontent}. Resume Details: {$reusmecontent}"
                    ]
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0.1,
            ]);

            return json_decode($response->choices[0]->message->content, true);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['resume_file' => 'حدث خطأ في معالجة تقييم السيرة الذاتية.']);
        }
    }
}

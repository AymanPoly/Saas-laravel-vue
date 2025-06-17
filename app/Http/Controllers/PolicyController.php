<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PolicyController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'policyType' => 'required|string',
            'companyDetails' => 'required|string',
            'additionalRequirements' => 'nullable|string'
        ]);

        // Here you would typically integrate with an AI service like OpenAI
        // For now, we'll return a template-based response
        $policy = $this->generatePolicyTemplate(
            $request->policyType,
            $request->companyDetails,
            $request->additionalRequirements
        );

        return response()->json(['policy' => $policy]);
    }

    public function downloadPdf(Request $request)
    {
        $request->validate([
            'policyType' => 'required|string',
            'companyDetails' => 'required|string',
            'additionalRequirements' => 'nullable|string'
        ]);

        $policy = $this->generatePolicyTemplate(
            $request->policyType,
            $request->companyDetails,
            $request->additionalRequirements
        );

        $pdf = PDF::loadHTML($policy);
        
        return $pdf->download('policy.pdf');
    }

    private function generatePolicyTemplate($type, $companyDetails, $additionalRequirements)
    {
        $templates = [
            'remote_work' => [
                'title' => 'Remote Work Policy',
                'sections' => [
                    'Purpose' => 'This policy outlines the guidelines and expectations for remote work arrangements.',
                    'Eligibility' => 'All employees who have completed their probationary period are eligible for remote work.',
                    'Work Hours' => 'Employees are expected to maintain regular business hours and be available during core working hours.',
                    'Communication' => 'Employees must maintain regular communication with their team and manager.',
                    'Equipment' => 'Employees are responsible for maintaining a suitable work environment and necessary equipment.'
                ]
            ],
            'harassment' => [
                'title' => 'Anti-Harassment Policy',
                'sections' => [
                    'Purpose' => 'This policy prohibits harassment of any kind in the workplace.',
                    'Definition' => 'Harassment includes but is not limited to verbal, physical, and visual conduct.',
                    'Reporting' => 'Employees should report any incidents of harassment to HR or their supervisor.',
                    'Investigation' => 'All complaints will be investigated promptly and confidentially.',
                    'Consequences' => 'Violations of this policy will result in disciplinary action up to and including termination.'
                ]
            ],
            'vacation' => [
                'title' => 'Vacation Policy',
                'sections' => [
                    'Purpose' => 'This policy outlines the guidelines for vacation time and leave.',
                    'Accrual' => 'Employees accrue vacation time based on their length of service.',
                    'Request Process' => 'Vacation requests must be submitted at least two weeks in advance.',
                    'Approval' => 'All vacation requests are subject to manager approval.',
                    'Carryover' => 'Unused vacation time may be carried over to the next year, subject to limits.'
                ]
            ],
            'data_security' => [
                'title' => 'Data Security Policy',
                'sections' => [
                    'Purpose' => 'This policy establishes guidelines for protecting company and client data.',
                    'Access Control' => 'Employees must use strong passwords and never share their credentials.',
                    'Data Handling' => 'Sensitive data must be encrypted and stored securely.',
                    'Reporting' => 'Security incidents must be reported immediately to IT.',
                    'Compliance' => 'All employees must comply with relevant data protection regulations.'
                ]
            ]
        ];

        $template = $templates[$type] ?? null;
        if (!$template) {
            return 'Invalid policy type selected.';
        }

        $policy = "<h1>{$template['title']}</h1>\n\n";
        $policy .= "<p>Company Details: {$companyDetails}</p>\n\n";
        
        if ($additionalRequirements) {
            $policy .= "<p>Additional Requirements: {$additionalRequirements}</p>\n\n";
        }

        foreach ($template['sections'] as $section => $content) {
            $policy .= "<h2>{$section}</h2>\n";
            $policy .= "<p>{$content}</p>\n\n";
        }

        return $policy;
    }
} 
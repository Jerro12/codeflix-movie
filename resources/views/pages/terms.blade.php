@extends('layouts.app-new')

@section('title', 'Terms of Service')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="font-outfit text-4xl font-bold text-white mb-8">Terms of Service</h1>
    
    <div class="prose prose-invert max-w-none space-y-6 text-gray-300">
        <p class="text-lg">Last updated: {{ date('F d, Y') }}</p>
        
        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">1. Acceptance of Terms</h2>
            <p>By accessing or using Codeflix, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our service.</p>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">2. Description of Service</h2>
            <p>Codeflix is a subscription-based streaming service that provides access to movies, TV shows, and other entertainment content. The service is available on various devices including web browsers, mobile apps, and smart TVs.</p>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">3. Subscription and Billing</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>Subscription fees are billed in advance on a monthly basis</li>
                <li>You may cancel your subscription at any time</li>
                <li>Refunds are provided according to our refund policy</li>
                <li>We reserve the right to change subscription prices with notice</li>
                <li>Failed payments may result in service suspension</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">4. User Accounts</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>You must be at least 18 years old to create an account</li>
                <li>You are responsible for maintaining account security</li>
                <li>One subscription allows use on up to 4 devices simultaneously</li>
                <li>Account sharing outside your household is prohibited</li>
                <li>We may suspend accounts that violate these terms</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">5. Content Usage</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>All content is licensed, not sold, to you</li>
                <li>Content is for personal, non-commercial use only</li>
                <li>Downloading, copying, or distributing content is prohibited</li>
                <li>Content availability may vary by region and time</li>
                <li>We may remove content at any time</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">6. Prohibited Activities</h2>
            <p>You agree not to:</p>
            <ul class="list-disc list-inside mt-3 space-y-2">
                <li>Attempt to circumvent digital rights management</li>
                <li>Use VPNs to access region-restricted content</li>
                <li>Share login credentials with non-household members</li>
                <li>Use bots or automated systems to access the service</li>
                <li>Reverse engineer any aspect of the service</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">7. Limitation of Liability</h2>
            <p>Codeflix is provided "as is" without warranties of any kind. We are not liable for any indirect, incidental, or consequential damages arising from your use of the service.</p>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">8. Changes to Terms</h2>
            <p>We may modify these terms at any time. Continued use of the service after changes constitutes acceptance of the new terms. We will notify users of significant changes via email or service notifications.</p>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">9. Contact Information</h2>
            <p>For questions about these Terms of Service, please contact us at:</p>
            <p class="mt-3">
                <strong class="text-white">Email:</strong> <a href="mailto:legal@codeflix.com" class="text-codeflix-primary hover:underline">legal@codeflix.com</a>
            </p>
        </section>
    </div>

    <div class="mt-8">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-codeflix-primary hover:text-codeflix-primary/80 transition">
            <i class="fa-solid fa-arrow-left"></i> Go Back
        </a>
    </div>
</div>
@endsection

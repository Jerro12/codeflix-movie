@extends('layouts.app-new')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="font-outfit text-4xl font-bold text-white mb-8">Privacy Policy</h1>
    
    <div class="prose prose-invert max-w-none space-y-6 text-gray-300">
        <p class="text-lg">Last updated: {{ date('F d, Y') }}</p>
        
        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">1. Information We Collect</h2>
            <p>We collect information you provide directly to us, such as when you create an account, subscribe to our service, or contact us for support. This includes:</p>
            <ul class="list-disc list-inside mt-3 space-y-2">
                <li>Name and email address</li>
                <li>Payment information (processed securely through our payment partners)</li>
                <li>Profile information and preferences</li>
                <li>Watch history and viewing preferences</li>
                <li>Device information for streaming optimization</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">2. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul class="list-disc list-inside mt-3 space-y-2">
                <li>Provide, maintain, and improve our streaming services</li>
                <li>Process transactions and send related information</li>
                <li>Personalize your viewing experience with recommendations</li>
                <li>Send promotional communications (with your consent)</li>
                <li>Detect and prevent fraud and unauthorized access</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">3. Information Sharing</h2>
            <p>We do not sell, trade, or rent your personal information to third parties. We may share information with:</p>
            <ul class="list-disc list-inside mt-3 space-y-2">
                <li>Service providers who assist in our operations</li>
                <li>Payment processors for transaction handling</li>
                <li>Legal authorities when required by law</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">4. Data Security</h2>
            <p>We implement industry-standard security measures to protect your personal information, including encryption, secure servers, and regular security audits. However, no method of transmission over the Internet is 100% secure.</p>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">5. Your Rights</h2>
            <p>You have the right to:</p>
            <ul class="list-disc list-inside mt-3 space-y-2">
                <li>Access and update your personal information</li>
                <li>Delete your account and associated data</li>
                <li>Opt-out of promotional communications</li>
                <li>Request a copy of your data</li>
            </ul>
        </section>

        <section class="bg-codeflix-card rounded-xl p-6 mb-6">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">6. Contact Us</h2>
            <p>If you have questions about this Privacy Policy, please contact us at:</p>
            <p class="mt-3">
                <strong class="text-white">Email:</strong> <a href="mailto:privacy@codeflix.com" class="text-codeflix-primary hover:underline">privacy@codeflix.com</a>
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

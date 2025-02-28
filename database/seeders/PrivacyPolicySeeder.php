<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrivacyPolicy;

class PrivacyPolicySeeder extends Seeder
{
    public function run()
    {
        PrivacyPolicy::create([
            'content' => 'Welcome to Blogwizard! This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this policy carefully. If you do not agree with the terms of this privacy policy, please do not access the site.

            1. Information We Collect: We may collect information about you in a variety of ways, including personal data and derivative data.

            2. Use of Your Information: We may use your information to create and manage your account, send confirmation emails, respond to customer service requests, and improve our services.

            3. Disclosure of Your Information: We may share your information as required by law or with third-party service providers.

            4. Tracking Technologies: We may use cookies and other tracking technologies to improve your experience.

            5. Security of Your Information: We use various security measures to protect your personal information.

            6. Policy for Children: We do not knowingly collect information from children under the age of 13.

            7. Changes to This Privacy Policy: We may update this policy from time to time and will notify you of any changes.

            8. Contact Us: If you have questions about this policy, please contact us at support@gmail.com.',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Term; // Import the Term model

class TermsTableSeeder extends Seeder
{
    public function run()
    {
        Term::create([
            'content' => 'Welcome to Blogwizard! These terms and conditions outline the rules and regulations for the use of Blogwizard\'s website, located at Surat.

            1. Introduction: Welcome to Blogwizard! These terms and conditions outline the rules and regulations for the use of Blogwizard\'s website.

            2. Acceptance of Terms: By accessing this website, you accept these terms and conditions in full. If you do not agree with these terms and conditions or any part of these terms, you must not use this website.

            3. Intellectual Property Rights: Unless otherwise stated, Blogwizard and/or its licensors own the intellectual property rights for all material on Blogwizard. All intellectual property rights are reserved.

            4. User Comments: This website may offer an opportunity for users to post and exchange opinions and information in certain areas of the website.

            5. Limitation of Liability: In no event shall Blogwizard, nor any of its officers, directors, and employees, be liable for anything arising out of or in any way connected with your use of this website.

            6. Indemnification: You hereby indemnify to the fullest extent Blogwizard from and against any and/or all liabilities, costs, demands, causes of action, damages and expenses arising in any way related to your breach of any of the provisions of these Terms.

            7. Changes to These Terms: Blogwizard reserves the right to revise these terms at any time as it sees fit.

            8. Governing Law: These terms will be governed by and interpreted in accordance with the laws of India.

            9. Contact Information: If you have any questions about these Terms, please contact us at support@gmail.com.',
        ]);
    }
}

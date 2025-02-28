@extends('layouts.site')

@section('title', 'FAQ')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/site/css/faq.css') }}">

@endsection

@section('content')


<section class="page-title bg-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block text-center">
                    <span class="text-white">Blogwizard</span>
                    <h1 class="text-capitalize mb-4 text-lg">FAQ</h1>
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="{{ url('/') }}" class="text-white">Blogwizard</a></li>
                        <li class="list-inline-item"><span class="text-white">/</span></li>
                        <li class="list-inline-item text-white-50">FAQ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

 <header>
        <h1>FAQ</h1>
    </header>
    <main>
        <section>
            <h2>1. Frequently Asked Questions (FAQs)</h2>
            <div class="faq">
                <h3>Q1: How do I reset my password?</h3>
                <p>A: To reset your password, go to the login page and click on "Forgot Password?" Follow the instructions sent to your email.</p>
            </div>
            <div class="faq">
                <h3>Q2: How can I contact customer support?</h3>
                <p>A: You can contact customer support by emailing us at <a href="mailto:support@gmail.com">support@gmail.com</a> or by using the contact form below.</p>
            </div>
            <div class="faq">
                <h3>Q3: Where can I find the latest updates?</h3>
                <p>A: You can find the latest updates on our blog or by following us on our social media channels.</p>
            </div>
        </section>
            <section>
            <h2>2. Support Resources</h2>
            <p>Here are some helpful resources to assist you:</p>
            <ul>
                <li><a href="{{ route('pages.about') }}">About Us</a></li>
                <li><a href="{{route('pages.services')}}">Services</a></li>
                <li><a href="{{ route('pages.contact') }}">Contact</a></li>
            </ul>
        </section>
        <section>
            <h2>3. Contact Us</h2>
            <p>If you have any questions or need further assistance, please reach out to us:</p>
            <ul>
                <li>Email: <a href="mailto:support@gmail.com">support@gmail.com</a></li>
                <li>Phone: +1 (123) 456-7890</li>
                <li>Address: Gujarat, India.</li>
            </ul>
        </section>
            <section class="cta-2">
	<div class="container">
		<div class="cta-block p-5 rounded">
			<div class="row justify-content-center align-items-center ">
				<div class="col-lg-7 text-center text-lg-left">
					<span class="text-color">For Every type business</span>
					<h2 class="mt-2 text-white">Entrust Your Project to Our Best Team of Professionals</h2>
				</div>
				<div class="col-lg-4 text-center text-lg-right mt-4 mt-lg-0">
					<a href="{{ route('pages.contact') }}" class="btn btn-main btn-round-full">Contact Us</a>
				</div>
			</div>
		</div>
	</div>
</section>
        
        
    </main>
    <footer>
        <p>&copy; 2025, Blogwizard. All rights reserved.</p>
    </footer>

@endsection

@section('scripts')

@endsection

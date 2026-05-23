@extends('layouts.app')

@section('title', 'Contact Us - Sweet Crumbs Bakery')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <!-- Decorative backgrounds -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>
    <div class="absolute -top-40 -right-40 h-[500px] w-[500px] rounded-full bg-amber-50/50 blur-3xl"></div>
    
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Contact Us', 'url' => '#']]" />
        </div>

        <!-- Heading -->
        <x-section-heading 
            title="Let's Start a Sweet Conversation" 
            subtitle="Drop by our boutique, send us an email, or call our chefs"
            align="center"
        />

        <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 gap-x-12 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2">
            <!-- Contact Info & Map -->
            <div class="flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair">Get in Touch</h3>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Have a question about our ingredients, daily menu items, or want to discuss a custom cake for a wedding or corporate celebration? Fill out the form or reach us through any channel below.
                    </p>

                    <dl class="mt-10 space-y-6 text-base leading-7 text-gray-600">
                        <!-- Address -->
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Address</span>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gold/10 text-gold text-lg">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                            </dt>
                            <dd class="flex items-center">
                                <span>123 Bakers Street, Gourmet District, New Delhi, 110001</span>
                            </dd>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Telephone</span>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gold/10 text-gold text-lg">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </dt>
                            <dd class="flex items-center">
                                <a class="hover:text-gold transition-colors duration-300 font-semibold" href="tel:+919876543210">+91 98765 43210</a>
                            </dd>
                        </div>

                        <!-- Email -->
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Email</span>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gold/10 text-gold text-lg">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                            </dt>
                            <dd class="flex items-center">
                                <a class="hover:text-gold transition-colors duration-300 font-semibold" href="mailto:hello@sweetcrumbs.com">hello@sweetcrumbs.com</a>
                            </dd>
                        </div>

                        <!-- Opening Hours -->
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Hours</span>
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gold/10 text-gold text-lg">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                            </dt>
                            <dd>
                                <span class="font-bold text-coffee">Mon - Sat:</span> 7:00 AM - 9:00 PM <br>
                                <span class="font-bold text-coffee">Sunday:</span> 8:00 AM - 6:00 PM
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Styled Map Container -->
                <div class="mt-12 overflow-hidden rounded-3xl border border-amber-100 shadow-md h-72 relative group">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.996160538965!2d77.21832131508272!3d28.629864282419163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd3655555555%3A0xe54ef8f0b78cf6b4!2sConnaught%20Place%2C%20New%20Delhi%2C%20Delhi%20110001!5e0!3m2!1sen!2sin!4v1653139871234!5m2!1sen!2sin" 
                        class="w-full h-full border-0 grayscale opacity-90 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="bg-white/80 backdrop-blur-md border border-amber-100 p-8 sm:p-10 rounded-3xl shadow-xl">
                <h3 class="text-xl font-bold tracking-tight text-coffee font-playfair mb-6">Send Us a Message</h3>
                
                @if(session('success'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-emerald-800 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                        <!-- Name -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-semibold leading-6 text-coffee">Your Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" autocomplete="name" required
                                       value="{{ old('name') }}"
                                       class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gold bg-cream/30 text-sm leading-6" />
                                @error('name')
                                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold leading-6 text-coffee">Email Address</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" autocomplete="email" required
                                       value="{{ old('email') }}"
                                       class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gold bg-cream/30 text-sm leading-6" />
                                @error('email')
                                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold leading-6 text-coffee">Phone Number (Optional)</label>
                            <div class="mt-2">
                                <input type="tel" name="phone" id="phone" autocomplete="tel"
                                       value="{{ old('phone') }}"
                                       class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gold bg-cream/30 text-sm leading-6" />
                                @error('phone')
                                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="sm:col-span-2">
                            <label for="subject" class="block text-sm font-semibold leading-6 text-coffee">Subject</label>
                            <div class="mt-2">
                                <input type="text" name="subject" id="subject" required
                                       value="{{ old('subject') }}"
                                       class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gold bg-cream/30 text-sm leading-6" />
                                @error('subject')
                                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold leading-6 text-coffee">Message</label>
                            <div class="mt-2">
                                <textarea name="message" id="message" rows="5" required
                                          class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gold bg-cream/30 text-sm leading-6">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit" 
                                class="w-full rounded-2xl bg-coffee px-6 py-4 text-center text-sm font-semibold text-cream shadow-md hover:bg-gold hover:shadow-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold transition-all duration-300">
                            Send Message &nbsp;<i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Custom Celebration Cakes - Sweet Crumbs Architect')

@section('content')
@php
    $cakeTypes = $options->get('cake_type', collect());
    $sizes = $options->get('size', collect());
    $shapes = $options->get('shape', collect());
    $flavors = $options->get('flavor', collect());
    $fillings = $options->get('filling', collect());
    $defaultSize = $sizes->first();
@endphp
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Custom Cakes', 'url' => '#']]" />
        </div>

        <x-section-heading
            title="Design Your Dream Celebration Cake"
            subtitle="Choose your layers, artisanal fillings, toppings, and let our master chefs bake your custom masterpiece"
            align="center"
        />

        @if(session('success'))
            <div class="mx-auto max-w-3xl mb-10 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-emerald-800 text-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($cakeTypes->isEmpty() || $sizes->isEmpty())
            <p class="text-center text-gray-600 py-12">Custom cake options are being configured. Please <a href="{{ route('contact') }}" class="text-gold font-semibold hover:underline">contact us</a> for a quote.</p>
        @else
        <div class="mx-auto mt-16 max-w-4xl bg-white/80 backdrop-blur-md border border-amber-100 rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-3">
            <div class="bg-coffee p-8 text-cream flex flex-col justify-between lg:col-span-1">
                <div>
                    <h3 class="text-xl font-bold tracking-tight text-gold font-playfair">Your Custom Cake</h3>
                    <p class="mt-2 text-xs text-cream/70">Real-time design specs & estimated investment</p>

                    <div class="mt-8 space-y-4 text-sm border-t border-cream/10 pt-6">
                        <div class="flex justify-between"><span class="text-cream/60">Occasion:</span><span id="preview-cake-type" class="font-bold text-cream">{{ $cakeTypes->first()->value }}</span></div>
                        <div class="flex justify-between"><span class="text-cream/60">Size:</span><span id="preview-size" class="font-bold text-cream">{{ $defaultSize?->value }}</span></div>
                        <div class="flex justify-between"><span class="text-cream/60">Shape:</span><span id="preview-shape" class="font-bold text-cream">{{ $shapes->first()?->value ?? 'Round' }}</span></div>
                        <div class="flex justify-between"><span class="text-cream/60">Base Flavor:</span><span id="preview-flavor" class="font-bold text-cream">{{ $flavors->first()?->value ?? '—' }}</span></div>
                        <div class="flex justify-between"><span class="text-cream/60">Filling:</span><span id="preview-filling" class="font-bold text-cream">{{ $fillings->first()?->value ?? 'None' }}</span></div>
                    </div>
                </div>

                <div class="mt-12 border-t border-cream/10 pt-6">
                    <p class="text-xs text-cream/60">Estimated Cost</p>
                    <div class="flex items-baseline gap-1 mt-1 text-gold">
                        <span class="text-3xl font-extrabold font-playfair">{{ $bakery['currency_symbol'] ?? '₹' }}</span>
                        <span id="estimated-price" class="text-4xl font-extrabold font-playfair">{{ (int) ($defaultSize?->price_addon ?? 0) }}</span>
                        <span class="text-xs text-cream/60 font-semibold ml-1">*Tentative</span>
                    </div>
                    <p class="mt-2 text-[10px] text-cream/50 leading-relaxed">Final pricing depends on specific chef hand-detailing and decorations.</p>
                </div>
            </div>

            <form action="{{ route('custom-cake.store') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10 lg:col-span-2 space-y-8">
                @csrf

                <div id="step-content-1" class="space-y-6">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 1: Choose Cake Base & Shape</h3>

                    <div>
                        <label for="cake_type" class="block text-sm font-semibold text-coffee">Cake Occasion / Type</label>
                        <select name="cake_type" id="cake_type" onchange="updateCakePreview()" required class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            @foreach($cakeTypes as $opt)
                            <option value="{{ $opt->value }}" data-price="{{ $opt->price_addon }}">{{ $opt->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="size" class="block text-sm font-semibold text-coffee">Size & Servings</label>
                        <select name="size" id="size" onchange="updateCakePreview()" required class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            @foreach($sizes as $opt)
                            <option value="{{ $opt->value }}" data-price="{{ $opt->price_addon }}">{{ $opt->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($shapes->isNotEmpty())
                    <div>
                        <label for="shape" class="block text-sm font-semibold text-coffee">Cake Shape</label>
                        <select name="shape" id="shape" onchange="updateCakePreview()" required class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            @foreach($shapes as $opt)
                            <option value="{{ $opt->value }}" data-price="{{ $opt->price_addon }}">{{ $opt->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="flex justify-end pt-4">
                        <button type="button" onclick="goToStep(2)" class="rounded-xl bg-coffee px-5 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Next Step &nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <div id="step-content-2" class="space-y-6 hidden">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 2: Signature Flavors & Fillings</h3>

                    @if($flavors->isNotEmpty())
                    <div>
                        <label for="flavor" class="block text-sm font-semibold text-coffee">Cake Base Flavor</label>
                        <select name="flavor" id="flavor" onchange="updateCakePreview()" required class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            @foreach($flavors as $opt)
                            <option value="{{ $opt->value }}" data-price="{{ $opt->price_addon }}">{{ $opt->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if($fillings->isNotEmpty())
                    <div>
                        <label for="filling" class="block text-sm font-semibold text-coffee">Layer Filling (Optional)</label>
                        <select name="filling" id="filling" onchange="updateCakePreview()" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            @foreach($fillings as $opt)
                            <option value="{{ $opt->value }}" data-price="{{ $opt->price_addon }}">{{ $opt->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="flex justify-between pt-4">
                        <button type="button" onclick="goToStep(1)" class="rounded-xl border border-amber-200 bg-white px-5 py-3 text-xs font-semibold text-coffee hover:bg-cream transition-colors duration-300"><i class="fa-solid fa-arrow-left"></i> &nbsp;Previous</button>
                        <button type="button" onclick="goToStep(3)" class="rounded-xl bg-coffee px-5 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Next Step &nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <div id="step-content-3" class="space-y-6 hidden">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 3: Design Details & Delivery</h3>

                    <div>
                        <label for="message_on_cake" class="block text-sm font-semibold text-coffee">Message on Cake (Max 30 characters)</label>
                        <input type="text" name="message_on_cake" id="message_on_cake" maxlength="30" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                    </div>

                    <div>
                        <label for="decoration" class="block text-sm font-semibold text-coffee">Decoration & Theme Description</label>
                        <textarea name="decoration" id="decoration" rows="3" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-coffee">Contact Name</label>
                            <input type="text" name="name" id="name" required value="{{ old('name', Auth::user()?->name) }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-coffee">Contact Phone</label>
                            <input type="tel" name="phone" id="phone" required value="{{ old('phone', Auth::user()?->phone) }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-coffee">Contact Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email', Auth::user()?->email) }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <div>
                            <label for="delivery_date" class="block text-sm font-semibold text-coffee">Expected Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" required min="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <div>
                            <label for="budget" class="block text-sm font-semibold text-coffee">Estimated Budget (Optional)</label>
                            <input type="number" name="budget" id="budget" class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                    </div>

                    <div>
                        <label for="images" class="block text-sm font-semibold text-coffee">Reference Design Upload (Optional)</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-coffee hover:file:bg-amber-100 cursor-pointer" />
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button" onclick="goToStep(2)" class="rounded-xl border border-amber-200 bg-white px-5 py-3 text-xs font-semibold text-coffee hover:bg-cream transition-colors duration-300"><i class="fa-solid fa-arrow-left"></i> &nbsp;Previous</button>
                        <button type="submit" class="rounded-xl bg-gold px-6 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-coffee transition-colors duration-300">Submit Design Specs &nbsp;<i class="fa-solid fa-wand-magic-sparkles"></i></button>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

@if($cakeTypes->isNotEmpty() && $sizes->isNotEmpty())
<script>
    function goToStep(stepNum) {
        [1, 2, 3].forEach(n => document.getElementById('step-content-' + n).classList.add('hidden'));
        document.getElementById('step-content-' + stepNum).classList.remove('hidden');
    }

    function getPrice(selectId) {
        const el = document.getElementById(selectId);
        if (!el) return 0;
        return parseFloat(el.options[el.selectedIndex].dataset.price) || 0;
    }

    function updateCakePreview() {
        const fields = ['cake_type', 'size', 'shape', 'flavor', 'filling'];
        fields.forEach(id => {
            const el = document.getElementById(id);
            const preview = document.getElementById('preview-' + id.replace('_', '-'));
            if (el && preview) preview.textContent = el.value;
        });

        const total = getPrice('size') + getPrice('cake_type') + getPrice('shape') + getPrice('flavor') + getPrice('filling');
        document.getElementById('estimated-price').textContent = Math.round(total);
    }

    document.addEventListener('DOMContentLoaded', updateCakePreview);
</script>
@endif
@endsection

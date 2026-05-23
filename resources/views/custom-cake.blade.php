@extends('layouts.app')

@section('title', 'Custom Celebration Cakes - Sweet Crumbs Architect')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <!-- Background accents -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Custom Cakes', 'url' => '#']]" />
        </div>

        <!-- Heading -->
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

        <div class="mx-auto mt-16 max-w-4xl bg-white/80 backdrop-blur-md border border-amber-100 rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-3">
            <!-- Left Side: Interactive Price Calculator & Preview -->
            <div class="bg-coffee p-8 text-cream flex flex-col justify-between lg:col-span-1">
                <div>
                    <h3 class="text-xl font-bold tracking-tight text-gold font-playfair">Your Custom Cake</h3>
                    <p class="mt-2 text-xs text-cream/70">Real-time design specs & estimated investment</p>
                    
                    <div class="mt-8 space-y-4 text-sm border-t border-cream/10 pt-6">
                        <div class="flex justify-between">
                            <span class="text-cream/60">Occasion:</span>
                            <span id="preview-type" class="font-bold text-cream">Birthday</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-cream/60">Size:</span>
                            <span id="preview-size" class="font-bold text-cream">1 kg (Serves 8-10)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-cream/60">Shape:</span>
                            <span id="preview-shape" class="font-bold text-cream">Round</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-cream/60">Base Flavor:</span>
                            <span id="preview-flavor" class="font-bold text-cream">Vanilla Bean</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-cream/60">Filling:</span>
                            <span id="preview-filling" class="font-bold text-cream">None</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 border-t border-cream/10 pt-6">
                    <p class="text-xs text-cream/60">Estimated Cost</p>
                    <div class="flex items-baseline gap-1 mt-1 text-gold">
                        <span class="text-3xl font-extrabold font-playfair">₹</span>
                        <span id="estimated-price" class="text-4xl font-extrabold font-playfair">1200</span>
                        <span class="text-xs text-cream/60 font-semibold ml-1">*Tentative</span>
                    </div>
                    <p class="mt-2 text-[10px] text-cream/50 leading-relaxed">Final pricing depends on specific chef hand-detailing and decorations. Our representative will contact you with a finalized invoice.</p>
                </div>
            </div>

            <!-- Right Side: Multi-Step Interactive Form -->
            <form action="{{ route('custom-cake.store') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-10 lg:col-span-2 space-y-8">
                @csrf
                
                <!-- Step Navigation Indicators -->
                <div class="flex justify-between items-center border-b border-amber-50 pb-6 mb-8 text-xs font-bold text-gray-400">
                    <div class="flex items-center gap-2 text-gold" id="step-ind-1">
                        <span class="h-6 w-6 rounded-full bg-gold/10 flex items-center justify-center text-xs">1</span>
                        <span>Base Specs</span>
                    </div>
                    <div class="h-0.5 flex-1 bg-amber-50 mx-2"></div>
                    <div class="flex items-center gap-2" id="step-ind-2">
                        <span class="h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs">2</span>
                        <span>Flavors</span>
                    </div>
                    <div class="h-0.5 flex-1 bg-amber-50 mx-2"></div>
                    <div class="flex items-center gap-2" id="step-ind-3">
                        <span class="h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs">3</span>
                        <span>Details</span>
                    </div>
                </div>

                <!-- STEP 1: BASE SPECS -->
                <div id="step-content-1" class="space-y-6">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 1: Choose Cake Base & Shape</h3>
                    
                    <!-- Cake Type -->
                    <div>
                        <label for="cake_type" class="block text-sm font-semibold text-coffee">Cake Occasion / Type</label>
                        <select name="cake_type" id="cake_type" onchange="updateCakePreview()" required
                                class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            <option value="Birthday" data-price="0">Celebration / Birthday Cake</option>
                            <option value="Wedding" data-price="500">Luxury Multi-Tier Wedding Cake (+₹500)</option>
                            <option value="Anniversary" data-price="200">Elegant Anniversary Cake (+₹200)</option>
                            <option value="Baby Shower" data-price="100">Playful Baby Shower Cake (+₹100)</option>
                        </select>
                    </div>

                    <!-- Size (Weight) -->
                    <div>
                        <label for="size" class="block text-sm font-semibold text-coffee">Size & Servings</label>
                        <select name="size" id="size" onchange="updateCakePreview()" required
                                class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            <option value="1 kg" data-price="1200">1.0 kg (Serves 8-10) - Base ₹1,200</option>
                            <option value="1.5 kg" data-price="1800">1.5 kg (Serves 12-15) - Base ₹1,800</option>
                            <option value="2.0 kg" data-price="2400">2.0 kg (Serves 16-20) - Base ₹2,400</option>
                            <option value="3.0 kg" data-price="3600">3.0 kg (Serves 25-30) - Base ₹3,600</option>
                            <option value="5.0 kg" data-price="6000">5.0 kg (Serves 40-50) - Base ₹6,000</option>
                        </select>
                    </div>

                    <!-- Shape -->
                    <div>
                        <label for="shape" class="block text-sm font-semibold text-coffee">Cake Shape</label>
                        <select name="shape" id="shape" onchange="updateCakePreview()" required
                                class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            <option value="Round" data-price="0">Traditional Round</option>
                            <option value="Square" data-price="100">Modern Square (+₹100)</option>
                            <option value="Heart" data-price="200">Romantic Heart-Shaped (+₹200)</option>
                        </select>
                    </div>

                    <!-- Nav buttons -->
                    <div class="flex justify-end pt-4">
                        <button type="button" onclick="goToStep(2)" class="rounded-xl bg-coffee px-5 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Next Step &nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- STEP 2: FLAVORS & FILLINGS -->
                <div id="step-content-2" class="space-y-6 hidden">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 2: Signature Flavors & Fillings</h3>

                    <!-- Flavor -->
                    <div>
                        <label for="flavor" class="block text-sm font-semibold text-coffee">Cake Base Flavor</label>
                        <select name="flavor" id="flavor" onchange="updateCakePreview()" required
                                class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            <option value="Vanilla Bean" data-price="0">Premium Madagascar Vanilla Bean</option>
                            <option value="Dark Chocolate Truffle" data-price="150">Belgian Dark Chocolate Truffle (+₹150)</option>
                            <option value="Royal Velvet" data-price="200">Gourmet Royal Red Velvet (+₹200)</option>
                            <option value="Salted Caramel Pecan" data-price="250">Golden Salted Caramel Pecan (+₹250)</option>
                        </select>
                    </div>

                    <!-- Filling -->
                    <div>
                        <label for="filling" class="block text-sm font-semibold text-coffee">Layer Filling (Optional)</label>
                        <select name="filling" id="filling" onchange="updateCakePreview()"
                                class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                            <option value="None" data-price="0">Standard Cream Filling (No charge)</option>
                            <option value="Fresh Raspberry Coulis" data-price="100">Fresh Raspberry Coulis (+₹100)</option>
                            <option value="Chocolate Ganache" data-price="120">Silky Dark Chocolate Ganache (+₹120)</option>
                            <option value="Salted Caramel" data-price="80">House Salted Caramel Spread (+₹80)</option>
                        </select>
                    </div>

                    <!-- Nav buttons -->
                    <div class="flex justify-between pt-4">
                        <button type="button" onclick="goToStep(1)" class="rounded-xl border border-amber-200 bg-white px-5 py-3 text-xs font-semibold text-coffee hover:bg-cream transition-colors duration-300"><i class="fa-solid fa-arrow-left"></i> &nbsp;Previous</button>
                        <button type="button" onclick="goToStep(3)" class="rounded-xl bg-coffee px-5 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Next Step &nbsp;<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- STEP 3: DETAILS & BUDGET -->
                <div id="step-content-3" class="space-y-6 hidden">
                    <h3 class="text-lg font-bold text-coffee font-playfair border-b border-amber-50 pb-2">Step 3: Design Details & Delivery</h3>

                    <!-- Message on Cake -->
                    <div>
                        <label for="message_on_cake" class="block text-sm font-semibold text-coffee">Message on Cake (Max 30 characters)</label>
                        <input type="text" name="message_on_cake" id="message_on_cake" placeholder="e.g. Happy 30th Anniversary Rohit!" maxlength="30"
                               class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                    </div>

                    <!-- Decoration Description -->
                    <div>
                        <label for="decoration" class="block text-sm font-semibold text-coffee">Decoration & Theme Description</label>
                        <textarea name="decoration" id="decoration" rows="3" placeholder="Describe the look you want (e.g. elegant gold pearls, minimal floral pattern, jungle baby theme)..."
                                  class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <!-- Name & Contact -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-coffee">Contact Name</label>
                            <input type="text" name="name" id="name" required value="{{ Auth::user() ? Auth::user()->name : '' }}"
                                   class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-coffee">Contact Phone</label>
                            <input type="tel" name="phone" id="phone" required value="{{ Auth::user() ? Auth::user()->phone : '' }}"
                                   class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <!-- Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-coffee">Contact Email</label>
                            <input type="email" name="email" id="email" required value="{{ Auth::user() ? Auth::user()->email : '' }}"
                                   class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <!-- Delivery Date -->
                        <div>
                            <label for="delivery_date" class="block text-sm font-semibold text-coffee">Expected Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" required min="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}"
                                   class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block text-sm font-semibold text-coffee">Estimated Budget (Optional)</label>
                            <input type="number" name="budget" id="budget" placeholder="e.g. 3000"
                                   class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label for="images" class="block text-sm font-semibold text-coffee">Reference Design Upload (Optional)</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                               class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-coffee hover:file:bg-amber-100 cursor-pointer" />
                    </div>

                    <!-- Nav buttons -->
                    <div class="flex justify-between pt-4">
                        <button type="button" onclick="goToStep(2)" class="rounded-xl border border-amber-200 bg-white px-5 py-3 text-xs font-semibold text-coffee hover:bg-cream transition-colors duration-300"><i class="fa-solid fa-arrow-left"></i> &nbsp;Previous</button>
                        <button type="submit" class="rounded-xl bg-gold px-6 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-coffee transition-colors duration-300">Submit Design Specs &nbsp;<i class="fa-solid fa-wand-magic-sparkles"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function goToStep(stepNum) {
        // Hide all step contents
        document.getElementById('step-content-1').classList.add('hidden');
        document.getElementById('step-content-2').classList.add('hidden');
        document.getElementById('step-content-3').classList.add('hidden');
        
        // Show selected step content
        document.getElementById('step-content-' + stepNum).classList.remove('hidden');

        // Reset step indicators
        const ind1 = document.getElementById('step-ind-1');
        const ind2 = document.getElementById('step-ind-2');
        const ind3 = document.getElementById('step-ind-3');

        ind1.classList.remove('text-gold');
        ind2.classList.remove('text-gold');
        ind3.classList.remove('text-gold');

        const span1 = ind1.querySelector('span');
        const span2 = ind2.querySelector('span');
        const span3 = ind3.querySelector('span');

        span1.className = "h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs";
        span2.className = "h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs";
        span3.className = "h-6 w-6 rounded-full bg-gray-100 flex items-center justify-center text-xs";

        if(stepNum >= 1) {
            ind1.classList.add('text-gold');
            span1.className = "h-6 w-6 rounded-full bg-gold/10 flex items-center justify-center text-xs";
        }
        if(stepNum >= 2) {
            ind2.classList.add('text-gold');
            span2.className = "h-6 w-6 rounded-full bg-gold/10 flex items-center justify-center text-xs";
        }
        if(stepNum >= 3) {
            ind3.classList.add('text-gold');
            span3.className = "h-6 w-6 rounded-full bg-gold/10 flex items-center justify-center text-xs";
        }
    }

    function updateCakePreview() {
        const typeSelect = document.getElementById('cake_type');
        const sizeSelect = document.getElementById('size');
        const shapeSelect = document.getElementById('shape');
        const flavorSelect = document.getElementById('flavor');
        const fillingSelect = document.getElementById('filling');

        const type = typeSelect.value;
        const size = sizeSelect.value;
        const shape = shapeSelect.value;
        const flavor = flavorSelect.value;
        const filling = fillingSelect.value;

        // Update previews
        document.getElementById('preview-type').textContent = type;
        document.getElementById('preview-size').textContent = size;
        document.getElementById('preview-shape').textContent = shape;
        document.getElementById('preview-flavor').textContent = flavor;
        document.getElementById('preview-filling').textContent = filling;

        // Calculate estimated cost
        const sizePrice = parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);
        const typePrice = parseFloat(typeSelect.options[typeSelect.selectedIndex].dataset.price);
        const shapePrice = parseFloat(shapeSelect.options[shapeSelect.selectedIndex].dataset.price);
        const flavorPrice = parseFloat(flavorSelect.options[flavorSelect.selectedIndex].dataset.price);
        const fillingPrice = parseFloat(fillingSelect.options[fillingSelect.selectedIndex].dataset.price);

        const total = sizePrice + typePrice + shapePrice + flavorPrice + fillingPrice;
        
        document.getElementById('estimated-price').textContent = total;
    }

    // Run preview update on mount
    document.addEventListener('DOMContentLoaded', () => {
        updateCakePreview();
    });
</script>
@endsection

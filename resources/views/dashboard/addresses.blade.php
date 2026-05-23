@extends('layouts.dashboard')

@section('title', 'Manage Addresses')

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Header Section -->
    <div class="border-b border-coffee-100 dark:border-gray-800 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Saved Addresses</h1>
            <p class="text-sm text-coffee-600 dark:text-gray-400 mt-1">Manage delivery locations for lightning-fast checkout</p>
        </div>
        <button onclick="toggleAddressForm('add')" class="inline-flex items-center gap-2 px-5 py-3 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-sm shadow-warm transition-transform active:scale-95 text-center">
            <i class="fa-solid fa-plus"></i> Add New Address
        </button>
    </div>

    <!-- Add/Edit Address Form Box (Hidden by default, styled beautifully) -->
    <div id="address-form-wrapper" class="hidden bg-white dark:bg-gray-800 rounded-3xl border border-bakery-gold-300 p-8 shadow-warm transition-all duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 id="form-title" class="font-display text-xl font-bold text-coffee-900 dark:text-white">Add New Address</h2>
            <button onclick="toggleAddressForm()" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form id="address-form" action="{{ route('dashboard.addresses.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Label -->
                <div>
                    <label for="label" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Address Label</label>
                    <input type="text" name="label" id="label" placeholder="e.g. Home, Office, Secret Cave" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- Address Line 1 -->
                <div class="md:col-span-2">
                    <label for="address_line_1" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Street Address</label>
                    <input type="text" name="address_line_1" id="address_line_1" placeholder="Flat No, Building, Street Name" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- Address Line 2 -->
                <div class="md:col-span-3">
                    <label for="address_line_2" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Apartment, Landmark, Suite (Optional)</label>
                    <input type="text" name="address_line_2" id="address_line_2" placeholder="Near Chocolate fountain" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">City</label>
                    <input type="text" name="city" id="city" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">State</label>
                    <input type="text" name="state" id="state" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- Zip Code -->
                <div>
                    <label for="zip_code" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Zip/Postal Code</label>
                    <input type="text" name="zip_code" id="zip_code" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Country</label>
                    <input type="text" name="country" id="country" value="India" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                </div>

                <!-- Default checkbox -->
                <div class="md:col-span-2 flex items-center pt-8">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_default" id="is_default" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-coffee-100 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-bakery-gold-500"></div>
                        <span class="ml-3 text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400">Set as Default Delivery Address</span>
                    </label>
                </div>
            </div>

            <!-- Form Submissions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-coffee-50 dark:border-gray-700">
                <button type="button" onclick="toggleAddressForm()" class="px-6 py-3 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-3 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Save Address
                </button>
            </div>
        </form>
    </div>

    <!-- Address Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Add New Dashed Card -->
        <button onclick="toggleAddressForm('add')" class="border-2 border-dashed border-coffee-200 dark:border-gray-700 hover:border-bakery-gold-400 bg-white dark:bg-gray-800/40 rounded-3xl p-8 flex flex-col items-center justify-center text-center group transition-all h-64 shadow-sm hover:shadow-warm">
            <span class="w-12 h-12 rounded-full bg-coffee-50 dark:bg-gray-700 flex items-center justify-center text-xl text-coffee-500 dark:text-coffee-300 group-hover:bg-bakery-gold-100 group-hover:text-bakery-gold-700 transition-colors mb-4">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span class="font-display font-bold text-coffee-800 dark:text-white text-lg">Add New Address</span>
            <span class="text-xs text-coffee-400 dark:text-gray-500 mt-1">Configure another delivery location</span>
        </button>

        <!-- Dynamic List -->
        @foreach($addresses as $addr)
            <div class="bg-white dark:bg-gray-800 rounded-3xl border {{ $addr->is_default ? 'border-bakery-gold-400 ring-1 ring-bakery-gold-400' : 'border-coffee-100 dark:border-gray-700' }} p-8 shadow-warm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-64 relative overflow-hidden">
                @if($addr->is_default)
                    <div class="absolute top-0 right-0 bg-bakery-gold-500 text-coffee-950 font-extrabold uppercase tracking-widest text-[9px] px-3.5 py-1 rounded-bl-2xl shadow-sm">
                        Default
                    </div>
                @endif

                <div>
                    <h3 class="font-display font-bold text-xl text-coffee-950 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-bakery-gold-500"></i> {{ $addr->label }}
                    </h3>
                    
                    <p class="text-sm text-coffee-600 dark:text-gray-300 mt-4 leading-relaxed line-clamp-3">
                        {{ $addr->address_line_1 }}<br>
                        @if($addr->address_line_2)
                            {{ $addr->address_line_2 }}<br>
                        @endif
                        {{ $addr->city }}, {{ $addr->state }} - {{ $addr->zip_code }}
                    </p>
                </div>

                <div class="flex items-center gap-4 border-t border-coffee-50 dark:border-gray-700 pt-4 mt-4">
                    <button onclick="editAddress({{ json_encode($addr) }})" class="text-xs font-bold text-coffee-500 dark:text-gray-400 hover:text-bakery-gold-600 dark:hover:text-bakery-gold-400 transition-colors flex items-center gap-1">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>

                    <form action="{{ route('dashboard.addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-bold text-rose-500 hover:text-rose-700 transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-trash-can"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleAddressForm(mode = 'close') {
        const wrapper = document.getElementById('address-form-wrapper');
        const form = document.getElementById('address-form');
        const formTitle = document.getElementById('form-title');
        const formMethod = document.getElementById('form-method');

        if (mode === 'add') {
            form.reset();
            form.action = "{{ route('dashboard.addresses.store') }}";
            formMethod.value = "POST";
            formTitle.innerText = "Add New Address";
            wrapper.classList.remove('hidden');
            wrapper.scrollIntoView({ behavior: 'smooth' });
        } else if (mode === 'close') {
            wrapper.classList.add('hidden');
        }
    }

    function editAddress(address) {
        const wrapper = document.getElementById('address-form-wrapper');
        const form = document.getElementById('address-form');
        const formTitle = document.getElementById('form-title');
        const formMethod = document.getElementById('form-method');

        // Bind values
        document.getElementById('label').value = address.label;
        document.getElementById('address_line_1').value = address.address_line_1;
        document.getElementById('address_line_2').value = address.address_line_2 || '';
        document.getElementById('city').value = address.city;
        document.getElementById('state').value = address.state;
        document.getElementById('zip_code').value = address.zip_code;
        document.getElementById('country').value = address.country;
        document.getElementById('is_default').checked = address.is_default;

        // Set action and method
        form.action = `/dashboard/addresses/${address.id}`;
        formMethod.value = "PUT";
        formTitle.innerText = "Edit Saved Address";

        wrapper.classList.remove('hidden');
        wrapper.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endpush

@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.products.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Create New Product</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Design a new addition to your bakery catalog</p>
        </div>
    </div>

    <!-- Product Form -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Signature Golden Pecan Cake" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Menu Category</label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-semibold">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Inventory Status</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-semibold">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Original Price (₹)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required placeholder="499.00" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Price -->
                <div>
                    <label for="discount_price" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Discount Price (₹, Optional)</label>
                    <input type="number" step="0.01" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" placeholder="Leave blank if no sale" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('discount_price')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Stock Quantity</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 20) }}" required placeholder="20" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('stock')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upload Images -->
                    <div>
                        <label for="images" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Upload Dessert Photos</label>
                        <input type="file" name="images[]" id="images" multiple class="w-full px-4 py-2.5 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all text-sm font-semibold file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-bakery-gold-500 file:text-coffee-950 hover:file:bg-bakery-gold-600">
                        @error('images')
                            <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- External Image URL -->
                    <div>
                        <label for="external_image_url" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Or Provide External Image URL</label>
                        <input type="url" name="external_image_url" id="external_image_url" value="{{ old('external_image_url') }}" placeholder="https://example.com/dessert-image.jpg" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                        @error('external_image_url')
                            <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- AI Assistant Panel -->
                <div class="md:col-span-2 bg-gradient-to-r from-amber-500/10 via-orange-500/5 to-transparent dark:from-amber-950/20 dark:via-orange-950/10 dark:to-transparent border border-amber-200/50 dark:border-amber-900/50 rounded-2xl p-6 relative overflow-hidden group shadow-sm transition-all duration-300 hover:shadow-md">
                    <!-- Absolute glow background element -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-bakery-gold-400/10 rounded-full blur-2xl group-hover:bg-bakery-gold-400/20 transition-all duration-500 animate-pulse"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
                        <div class="flex items-start gap-3">
                            <div class="p-3 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl">
                                <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-coffee-950 dark:text-amber-300 uppercase tracking-wider">AI Product Wizard</h3>
                                <p class="text-xs text-coffee-600 dark:text-gray-400 mt-0.5">Select a product photo or enter an image URL in the fields above, then click below to let AI automatically generate details.</p>
                            </div>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            <button type="button" id="btn-ai-autofill" class="flex items-center gap-2 px-5 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs shadow-md transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="spinner hidden mr-1"><i class="fa-solid fa-spinner animate-spin"></i></span>
                                <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                                <span>Autofill details using AI</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Progress / Status Indicator -->
                    <div id="ai-status-container" class="hidden mt-4 pt-4 border-t border-amber-200/50 dark:border-amber-900/30">
                        <div class="flex items-center justify-between mb-2">
                            <span id="ai-status-text" class="text-xs font-semibold text-amber-800 dark:text-amber-400">Uploading & analyzing image...</span>
                            <span id="ai-status-percent" class="text-xs font-bold text-amber-600 dark:text-amber-400">0%</span>
                        </div>
                        <div class="w-full h-1.5 bg-amber-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div id="ai-progress-bar" class="h-full bg-gradient-to-r from-amber-500 to-orange-500 transition-all duration-300 w-0"></div>
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Short Description (Snippet, max 255 characters)</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" placeholder="A gorgeous hazelnut mousse cake ideal for birthdays." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('short_description')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Full Description & Ingredients</label>
                    <textarea name="description" id="description" rows="5" required placeholder="Describe the baking process, notes, key allergens, organic details..." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Create Product
                </button>
            </div>

        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const aiBtn = document.getElementById('btn-ai-autofill');
    const fileInput = document.getElementById('images');
    const urlInput = document.getElementById('external_image_url');
    const statusContainer = document.getElementById('ai-status-container');
    const statusText = document.getElementById('ai-status-text');
    const progressBar = document.getElementById('ai-progress-bar');
    const progressPercent = document.getElementById('ai-status-percent');

    if (!aiBtn || !fileInput) return;

    aiBtn.addEventListener('click', () => {
        const hasFile = fileInput.files && fileInput.files.length > 0;
        const urlVal = urlInput ? urlInput.value.trim() : '';

        if (!hasFile && !urlVal) {
            window.showToast('Please select a dessert photo or enter an external image URL first.', 'error');
            return;
        }

        if (hasFile) {
            analyzeFile(fileInput.files[0]);
        } else {
            analyzeUrl(urlVal);
        }
    });

    function fillFormFields(data) {
        if (data.name) {
            const nameInput = document.getElementById('name');
            if (nameInput) nameInput.value = data.name;
        }
        
        if (data.price) {
            const priceInput = document.getElementById('price');
            if (priceInput) priceInput.value = data.price;
        }

        if (data.short_description) {
            const shortDescInput = document.getElementById('short_description');
            if (shortDescInput) shortDescInput.value = data.short_description;
        }

        if (data.description) {
            const descInput = document.getElementById('description');
            if (descInput) descInput.value = data.description;
        }

        if (data.category_id) {
            const categorySelect = document.getElementById('category_id');
            if (categorySelect) categorySelect.value = data.category_id;
        }
    }

    function analyzeFile(file) {
        if (!file.type.startsWith('image/')) {
            window.showToast('Please select a valid image file.', 'error');
            return;
        }

        aiBtn.disabled = true;
        aiBtn.querySelector('.spinner').classList.remove('hidden');
        statusContainer.classList.remove('hidden');
        updateProgress(10, 'Reading image file...');

        const formData = new FormData();
        formData.append('image', file);

        updateProgress(30, 'Sending to Groq AI Vision model...');

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        let progressVal = 30;
        const progressInterval = setInterval(() => {
            if (progressVal < 90) {
                progressVal += 5;
                updateProgress(progressVal, 'Analyzing image details with Groq Vision...');
            }
        }, 800);

        fetch('{{ route("admin.products.analyze-image") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            clearInterval(progressInterval);
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'Analysis failed'); });
            }
            return response.json();
        })
        .then(res => {
            if (res.success) {
                updateProgress(100, 'Analysis complete! Autofilling fields...');
                fillFormFields(res.data);
                window.showToast('Product details successfully autofilled!', 'success');
            } else {
                throw new Error(res.message || 'Failed to analyze image.');
            }
        })
        .catch(err => {
            clearInterval(progressInterval);
            window.showToast(err.message, 'error');
            updateProgress(0, 'Failed.');
            statusContainer.classList.add('hidden');
        })
        .finally(() => {
            aiBtn.disabled = false;
            aiBtn.querySelector('.spinner').classList.add('hidden');
            setTimeout(() => {
                statusContainer.classList.add('hidden');
            }, 3000);
        });
    }

    function analyzeUrl(url) {
        aiBtn.disabled = true;
        aiBtn.querySelector('.spinner').classList.remove('hidden');
        statusContainer.classList.remove('hidden');
        updateProgress(10, 'Resolving image URL...');

        const formData = new FormData();
        formData.append('image_url', url);

        updateProgress(30, 'Sending to Groq AI Vision model...');

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        let progressVal = 30;
        const progressInterval = setInterval(() => {
            if (progressVal < 90) {
                progressVal += 5;
                updateProgress(progressVal, 'Analyzing image details with Groq Vision...');
            }
        }, 800);

        fetch('{{ route("admin.products.analyze-image") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            clearInterval(progressInterval);
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message || 'Analysis failed'); });
            }
            return response.json();
        })
        .then(res => {
            if (res.success) {
                updateProgress(100, 'Analysis complete! Autofilling fields...');
                fillFormFields(res.data);
                window.showToast('Product details successfully autofilled!', 'success');
            } else {
                throw new Error(res.message || 'Failed to analyze image.');
            }
        })
        .catch(err => {
            clearInterval(progressInterval);
            window.showToast(err.message, 'error');
            updateProgress(0, 'Failed.');
            statusContainer.classList.add('hidden');
        })
        .finally(() => {
            aiBtn.disabled = false;
            aiBtn.querySelector('.spinner').classList.add('hidden');
            setTimeout(() => {
                statusContainer.classList.add('hidden');
            }, 3000);
        });
    }

    function updateProgress(percent, text) {
        progressBar.style.width = percent + '%';
        progressPercent.textContent = percent + '%';
        statusText.textContent = text;
    }
});
</script>
@endsection

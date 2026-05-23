@props(['items'])

<nav class="flex px-6 py-4 bg-coffee-50/50 dark:bg-gray-800/30 rounded-2xl border border-coffee-100/5 mb-8 text-xs font-semibold text-coffee-500 dark:text-gray-400">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="hover:text-coffee-700 dark:hover:text-white transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-house text-gold/80"></i> Home
            </a>
        </li>
        @foreach($items as $key => $value)
            @php
                $label = '';
                $url = '';
                if (is_array($value)) {
                    $label = $value['label'] ?? '';
                    $url = $value['url'] ?? '';
                } else {
                    $label = $key;
                    $url = $value;
                }
            @endphp
            <li>
                <div class="flex items-center gap-2">
                    <span class="text-coffee-300">/</span>
                    @if($url && $url !== '#')
                        <a href="{{ $url }}" class="hover:text-coffee-700 dark:hover:text-white transition-colors">{{ $label }}</a>
                    @else
                        <span class="text-coffee-800 dark:text-gray-300">{{ $label }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>

@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-coffee-200 focus:border-gold focus:ring-gold bg-cream/30 text-coffee rounded-xl shadow-sm transition-all px-4 py-2.5 text-sm placeholder-coffee-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:focus:border-gold dark:focus:ring-gold']) }}>


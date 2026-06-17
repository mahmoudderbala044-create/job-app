@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-zinc-900 border-white/10 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>

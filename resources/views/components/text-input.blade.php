@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-700 bg-slate-950/90 text-white placeholder:text-slate-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-3xl shadow-sm']) }}>

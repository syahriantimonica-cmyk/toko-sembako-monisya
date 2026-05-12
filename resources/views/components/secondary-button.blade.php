<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl font-medium text-sm text-slate-700 uppercase tracking-wider shadow-sm hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 disabled:opacity-25 transition duration-150']) }}>
    {{ $slot }}
</button>

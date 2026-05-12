<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-red-600 border border-transparent rounded-xl font-medium text-sm text-white uppercase tracking-wider shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150']) }}>
    {{ $slot }}
</button>

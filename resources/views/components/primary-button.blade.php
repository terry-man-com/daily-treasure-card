<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-white text-center uppercase tracking-widest transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

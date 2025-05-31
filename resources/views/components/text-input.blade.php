@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-form-gray border-none focus:ring-indigo-500 rounded-xl shadow-sm']) }}>

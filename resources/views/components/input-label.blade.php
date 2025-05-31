@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-small-base text-custom-gray py-3']) }}>
    {{ $value ?? $slot }}
</label>

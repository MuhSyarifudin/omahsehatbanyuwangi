@props(['error' => false])

<input {{ $attributes->merge([
    'class' => 'block w-full rounded-md shadow-sm sm:text-sm ' .
               ($error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500')
]) }} />

@error($attributes->get('name'))
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror

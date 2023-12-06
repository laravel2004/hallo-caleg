@props(['label', 'id', 'type', 'placeholder', 'required' => false])

<div>
    <label for="{{ $id }}" class="mb-2 block text-sm font-medium text-gray-900">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $id }}" id="{{ $id }}" placeholder="{{ $placeholder }}" class="@error($id) border-red-600 @enderror block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary focus:ring-primary sm:text-sm" value="{{ old($id) }}" @if ($required) required @endif>
    @error($id)
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

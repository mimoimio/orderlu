<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('vendor.menus.update', $menu) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="name" value="Menu Name" />
                        <x-input id="name" type="text" name="name" :value="old('name', $menu->name)" required autofocus
                            class="mt-1 block w-full" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $menu->description) }}</textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="price" value="Price (RM)" />
                        <x-input id="price" type="number" name="price" :value="old('price', $menu->price)" required step="0.01"
                            min="0" class="mt-1 block w-full" />
                        <x-input-error for="price" class="mt-2" />
                    </div>

                    @if ($menu->image_path)
                        <div>
                            <x-label value="Current Image" />
                            <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}"
                                class="mt-2 w-32 h-32 object-cover rounded-md">
                        </div>
                    @endif

                    <div>
                        <x-label for="image" value="New Menu Image (Optional)" />
                        <input type="file" id="image" name="image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Max 2MB. Accepted formats: JPG, PNG,
                            WEBP. Leave empty to keep current image.</p>
                        <x-input-error for="image" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_available" name="is_available" value="1"
                            {{ old('is_available', $menu->is_available) ? 'checked' : '' }}
                            class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                        <label for="is_available" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Available for
                            ordering</label>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('vendor.menus.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500">
                            Cancel
                        </a>
                        <x-button>
                            Update Menu Item
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

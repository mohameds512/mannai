
{{$photoPreview}}
<div x-data="{photoPreview: null}" x-init="FilePond.registerPlugin(FilePondPluginFileValidateSize, FilePondPluginImagePreview)">
    <form wire:submit.prevent="savePhoto" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="photo">
                Select a photo:
            </label>
            <input type="file" wire:model="photo" id="photo" name="photo" x-ref="photo" class="hidden"
                @change="photoPreview = URL.createObjectURL($refs.photo.files[0])">
            <div class="flex items-center justify-center w-full h-64 bg-gray-100 hover:bg-gray-200 cursor-pointer"
                x-on:click="$refs.photo.click()" x-bind:class="{'border-dashed border-2 border-gray-400': !photoPreview}">
                <template x-if="photoPreview">
                    <img x-bind:src="photoPreview" class="h-full object-contain">
                </template>
                <template x-if="!photoPreview">
                    <span class="text-gray-500 font-bold">Click to select a photo</span>
                </template>
            </div>
            @error('photo')
            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Upload Photo
        </button>
    </form>
</div>

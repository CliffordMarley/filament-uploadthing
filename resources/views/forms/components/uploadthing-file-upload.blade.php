<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="uploadThingFileUpload({
            state: $wire.entangle('{{ $getStatePath() }}'),
            endpoint: '{{ $getEndpoint() }}',
            apiKey: '{{ config('filament-uploadthing.api_key') }}',
            acceptedTypes: @js($getAcceptedFileTypes()),
            maxFileSize: {{ $getMaxFileSize() ?? 'null' }},
            maxFiles: {{ $getMaxFiles() }},
        })"
        class="filament-uploadthing-upload"
    >
        <div class="space-y-2">
            <!-- Upload Button -->
            <div
                x-show="!uploading && files.length < maxFiles"
                class="flex items-center justify-center w-full"
            >
                <label
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600"
                >
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500" x-show="acceptedTypes.length > 0" x-text="'Accepted: ' + acceptedTypes.join(', ')"></p>
                    </div>
                    <input
                        type="file"
                        class="hidden"
                        x-ref="fileInput"
                        @change="handleFileSelect"
                        :accept="acceptedTypes.join(',')"
                        :multiple="maxFiles > 1"
                    />
                </label>
            </div>

            <!-- Upload Progress -->
            <div x-show="uploading" class="space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span>Uploading...</span>
                    <span x-text="uploadProgress + '%'"></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-2.5 rounded-full" :style="'width: ' + uploadProgress + '%'"></div>
                </div>
            </div>

            <!-- Error Message -->
            <div x-show="error" class="text-sm text-red-600 dark:text-red-400" x-text="error"></div>

            <!-- Uploaded Files List -->
            <div x-show="files.length > 0" class="space-y-2">
                <template x-for="(file, index) in files" :key="index">
                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="file.name"></p>
                                <p class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></p>
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="removeFile(index)"
                            class="text-red-600 hover:text-red-800 dark:text-red-400"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-dynamic-component>
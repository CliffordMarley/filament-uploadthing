export default function uploadThingFileUpload({
    state,
    endpoint,
    apiKey,
    acceptedTypes = [],
    maxFileSize = null,
    maxFiles = 1,
}) {
    return {
        state,
        endpoint,
        apiKey,
        acceptedTypes,
        maxFileSize,
        maxFiles,
        files: [],
        uploading: false,
        uploadProgress: 0,
        error: null,

        init() {
            if (this.state) {
                this.files = Array.isArray(this.state) ? this.state : [this.state];
            }

            this.$watch('files', (value) => {
                this.state = this.maxFiles === 1 ? (value[0] || null) : value;
            });
        },

        async handleFileSelect(event) {
            const selectedFiles = Array.from(event.target.files);
            
            if (this.files.length + selectedFiles.length > this.maxFiles) {
                this.error = `Maximum ${this.maxFiles} file(s) allowed`;
                return;
            }

            for (const file of selectedFiles) {
                if (this.maxFileSize && file.size > this.maxFileSize) {
                    this.error = `File size exceeds maximum of ${this.formatFileSize(this.maxFileSize)}`;
                    continue;
                }

                await this.uploadFile(file);
            }

            event.target.value = '';
        },

        async uploadFile(file) {
            this.uploading = true;
            this.uploadProgress = 0;
            this.error = null;

            try {
                // Step 1: Get presigned URL from UploadThing
                const response = await fetch('https://api.uploadthing.com/v6/uploadFiles', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Uploadthing-Api-Key': this.apiKey,
                    },
                    body: JSON.stringify({
                        files: [{
                            name: file.name,
                            size: file.size,
                            type: file.type,
                        }],
                        metadata: {},
                        contentDisposition: 'inline',
                    }),
                });

                if (!response.ok) {
                    throw new Error('Failed to get upload URL');
                }

                const data = await response.json();
                const uploadData = data.data[0];

                // Step 2: Upload file to UploadThing
                const formData = new FormData();
                Object.entries(uploadData.fields).forEach(([key, value]) => {
                    formData.append(key, value);
                });
                formData.append('file', file);

                const uploadResponse = await fetch(uploadData.url, {
                    method: 'POST',
                    body: formData,
                });

                if (!uploadResponse.ok) {
                    throw new Error('Upload failed');
                }

                // Step 3: Add uploaded file info to state
                this.files.push({
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    url: uploadData.fileUrl,
                    key: uploadData.key,
                });

                this.uploadProgress = 100;
            } catch (error) {
                console.error('Upload error:', error);
                this.error = error.message || 'Upload failed';
            } finally {
                this.uploading = false;
                setTimeout(() => {
                    this.uploadProgress = 0;
                }, 1000);
            }
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        },
    };
}
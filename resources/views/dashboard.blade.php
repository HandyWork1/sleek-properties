<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <h1 class="text-2xl font-medium text-gray-700 dark:text-gray-100">
            {{ __('Welcome,') }} {{ Auth::user()->first_name ?? Auth::user()->first_name }}
        </h1>
        <div class="flex items-center justify-between mt-4">
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-gray-50">
                Get Started
            </h2>
            {{-- <x-dashboard-card :loading="$loading" title="Total Listings" :value="54" icon="building-office" bgColor="bg-blue-500" /> --}}
            <x-dashboard-card  title="Total Listings" :value="54" icon="building-office" bgColor="bg-blue-500" />
        </div>
        
        <!-- Add Listing Modal Trigger -->
        <button data-modal-target="add-listing-modal" data-modal-toggle="add-listing-modal" type="button"
            class="inline-flex items-center px-6 py-2 bg-yellow-500 text-gray-900 text-xs font-bold rounded hover:bg-yellow-400 transition">
            <x-heroicon-o-plus class="w-4 h-4 mr-3" />
            ADD A NEW LISTING
        </button>

        <!-- Listings Table -->
        <x-table
            :columns="[
            ['key'=>'id','label'=>'#'],
            ['key'=>'name','label'=>'Listing Name'],
            ['key'=>'size','label'=>'Size (sqft)', 'formatter'=>fn($row)=>format_size($row->size)],
            ['key'=>'bedrooms','label'=>'Bedrooms'],
            ['key'=>'location.name','label'=>'Location', 'formatter'=>'location'],
            ['key'=>'price','label'=>'Price', 'formatter'=>fn($row)=>format_price($row->price)],
            ['key'=>'agent','label'=>'Agent','formatter'=>'agent'],
            ['key'=>'created_at','label'=>'Date Listed', 'formatter'=>fn($row)=>format_date($row->created_at)],
            ['key'=>'status','label'=>'Status', 'formatter'=>'status'],
            ['key'=>'actions','label'=>'Actions','component'=>'table.cells.listing-actions']
            ]"
            :rows="$properties"
            :pagination="$properties"
        />

        <!-- Property Listing Modal -->
        <div id="add-listing-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden max-h-full bg-black/50 backdrop-blur-sm overflow-hidden">
            <div class="relative w-full max-w-4xl mx-auto mt-10 max-h-[90vh] overflow-y-auto">
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add New Listing
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900 dark:hover:text-white"
                            data-modal-hide="add-listing-modal">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form 
                        x-data="{
                            isValid: false,
                            checkValidity() {
                                this.isValid = $refs.form.checkValidity();
                            }
                        }"
                        x-init="checkValidity"
                        @input="checkValidity"
                        x-ref="form"
                        method="POST"
                        action="{{ route('properties.store') }}"
                        enctype="multipart/form-data"
                        class="p-6 space-y-6"
                        novalidate>
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-form.input name="name" label="Listing Name" required />
                            <x-form.input name="price" label="Price" type="number" step="0.01" required />
                            <x-form.input name="size" label="Size (sq ft)" type="number" step="0.01" required />
                            <x-form.select name="property_type_id" label="Property Type" :options="$propertyTypes->pluck('name', 'id')" required />
                            <x-form.input name="bedrooms" label="Number of Bedrooms" type="number" required />
                            <x-form.input name="bathrooms" label="Number of Bathrooms" type="number" required />

                            <x-form.select name="status" label="Status" :options="[
                                'for_sale' => 'For Sale',
                                'for_rent' => 'For Rent',
                                'sold' => 'Sold',
                                'rented' => 'Rented'
                            ]" required />

                            <x-form.select name="furnishing_status_id" label="Furnishing" :options="$furnishingStatuses->pluck('name', 'id')" required />
                            <x-form.select name="country_id" label="Country" :options="$countries->pluck('name', 'id')" required />
                            <x-form.select name="location_id" label="Locations" :options="$locations" required />
                            <x-form.select name="property_condition_id" label="Condition" :options="$propertyConditions->pluck('name', 'id')" required />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </textarea>
                        </div>

                        <!-- Property Images Upload -->
                        <div
                            x-data="{
                                success: @json(session('toast.type') === 'success'),
                                files: [],
                                addFiles(event) {
                                    [...event.target.files].forEach(file => {
                                        const reader = new FileReader();
                                        const extension = file.name.split('.').pop().toUpperCase();
                                        const size = (file.size / (1024 * 1024)).toFixed(2); // MB

                                        this.files.push({
                                            file,
                                            extension,
                                            size,
                                            uploaded: false,
                                            progress: 0,
                                            estimatedTime: 'Calculating...',
                                        });

                                        this.uploadFile(this.files.length - 1);
                                    });
                                },
                                uploadFile(index) {
                                    let elapsed = 0;
                                    let interval = setInterval(() => {
                                        const item = this.files[index];
                                        elapsed += 1;
                                        if (item.progress >= 100) {
                                            item.uploaded = true;
                                            item.estimatedTime = 'Upload complete';
                                            clearInterval(interval);
                                        } else {
                                            item.progress += 5;
                                            item.estimatedTime = `${Math.ceil((100 - item.progress) / 5)}s left`;
                                        }
                                    }, 100);
                                },
                                removeFile(index) {
                                    this.files.splice(index, 1);
                                }
                            }"
                            class="mb-6"
                        >
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Property Images</label>

                            <!-- Upload Box -->
                            <div class="border-2 border-dashed border-blue-400 p-6 rounded-md bg-white dark:bg-gray-800">
                                <!-- Image Validation Error -->
                                @if ($errors->has('images') || $errors->has('images.*'))
                                    <div class="mt-2 text-sm text-red-600 dark:text-red-400">
                                        {{ $errors->first('images') ?? $errors->first('images.*') }}
                                    </div>
                                @endif
                                <div class="flex flex-col items-center space-y-3">
                                    <x-heroicon-o-cloud-arrow-up class="w-10 h-10 text-blue-500" />
                                    <p class="text-sm text-gray-500 dark:text-gray-300">Drag and drop or</p>

                                    <label for="images"
                                        class="cursor-pointer hover:bg-blue-500 hover:border-transparent hover:text-white border border-blue-500 text-blue-500 px-4 py-2 rounded text-sm font-medium">
                                        Browse files
                                    </label>
                                    <input type="file" id="images" name="images[]" class="hidden" multiple @change="addFiles($event)" />
                                    <p class="text-xs text-gray-400 dark:text-gray-500">.jpg, .png, .svg, .zip only. Max 5MB</p>
                                </div>
                            </div>

                            <!-- Preview -->
                            <template x-if="files.length > 0">
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <template x-for="(item, index) in files" :key="index">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md shadow-sm relative">
                                            <div class="flex items-center space-x-3">
                                                <!-- File Icon -->
                                                <div class="w-10 h-12 bg-blue-100 dark:bg-blue-800 rounded-md flex items-center justify-center text-blue-600 dark:text-white text-xs font-bold uppercase">
                                                    <span x-text="item.extension"></span>
                                                </div>

                                                <div>
                                                    <p class="text-sm font-medium text-gray-800 dark:text-white" x-text="item.file.name"></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="`${item.size} MB`"></p>
                                                </div>

                                                <!-- Remove -->
                                                <button type="button" @click="removeFile(index)"
                                                    class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                                    <x-heroicon-o-x-circle class="w-5 h-5" />
                                                </button>
                                            </div>

                                            <!-- Upload Progress -->
                                            <div class="mt-4 space-y-1">
                                                <div class="w-full bg-gray-200 dark:bg-gray-600 h-2 rounded-full overflow-hidden">
                                                    <div class="h-full bg-blue-500 transition-all duration-300"
                                                        :style="`width: ${item.progress}%`"></div>
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 flex justify-between">
                                                    <span x-show="!item.uploaded">Uploading...</span>
                                                    <span x-text="item.estimatedTime"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>


                        <!-- Submit -->
                        <div class="flex justify-start space-x-4 pt-4">
                            <button @click="showModal = false"
                                class="px-8 py-2 border border-gray-300 rounded-md text-sm text-gray-700">Cancel</button>
                            <button type="submit"
                                :disabled="!isValid"
                                :class="isValid
                                    ? 'bg-yellow-500 hover:bg-yellow-400 text-gray-900'
                                    : 'bg-gray-300 text-white cursor-not-allowed'"
                                class="px-8 py-2 rounded-md text-sm font-semibold transition">
                                Add Listing
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

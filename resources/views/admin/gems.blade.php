@extends('admin.layouts.app')

@section('title', 'Manage Gems - Crystal Cavern')

@push('scripts')
<script>
async function createGem(formData) {
    try {
        const response = await fetch('/admin/gems', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        });
        if (!response.ok) {
            const errorData = await response.json(); 
            throw new Error(errorData.error || 'Failed to create Gem');
        }
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

async function updateGem(gemId, formData) {
    // If your routes expect PATCH, we can do an override:
    formData.append('_method', 'PATCH'); // or 'PUT'
    try {
        const response = await fetch(`/admin/gems/${gemId}`, {
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        });
        if (!response.ok) {
            throw new Error('Failed to update Gem');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function deleteGem(gemId) {
    try {
        const response = await fetch(`/admin/gems/${gemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        if (!response.ok) {
            throw new Error('Failed to delete Gem');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function manageGems() {
    return {
        // ------------------------------------------------
        // Data & Pagination
        // ------------------------------------------------
        gemsList: @json($rolesList),
        showEntries: 10,
        searchTerm: '',
        currentPage: 1,

        // ------------------------------------------------
        // Modal flags
        // ------------------------------------------------
        isAddOpen: false,
        isViewOpen: false,
        isEditOpen: false,
        isDeleteOpen: false,

        // Data form "Add Gem"
        addName: '',
        addDescription: '',
        addQuota: '',
        addFile: null,        // store actual File object
        addFilePreview: null, // store local URL for preview

        // Data terpilih (View/Edit/Delete)
        selectedGem: null,
        editFile: null,
        editFilePreview: null,

        // ------------------------------------------------
        // Computed / Getter
        // ------------------------------------------------
        get filteredList() {
            const term = this.searchTerm.toLowerCase().trim();
            if (!term) return this.gemsList;
            return this.gemsList.filter(item =>
                item.name.toLowerCase().includes(term) ||
                item.description.toLowerCase().includes(term)
            );
        },
        get totalPages() {
            return Math.ceil(this.filteredList.length / this.showEntries);
        },
        get paginatedData() {
            const start = (this.currentPage - 1) * this.showEntries;
            const end = start + this.showEntries;
            return this.filteredList.slice(start, end);
        },
        get showingText() {
            if (this.filteredList.length === 0) {
                return 'Showing 0 to 0 of 0 entries';
            }
            const start = (this.currentPage - 1) * this.showEntries + 1;
            const end = Math.min(this.currentPage * this.showEntries, this.filteredList.length);
            return `Showing ${start} to ${end} of ${this.filteredList.length} entries`;
        },

        // ------------------------------------------------
        // Methods: Pagination
        // ------------------------------------------------
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        // ------------------------------------------------
        // Methods: Add Gem
        // ------------------------------------------------
        resetAddForm() {
            this.addName = '';
            this.addDescription = '';
            this.addQuota = '';
            this.addFile = null;
            this.addFilePreview = null;
        },
        handleAddFile(event) {
            const file = event.target.files[0];
            if (file) {
                this.addFile = file;
                this.addFilePreview = URL.createObjectURL(file);
            } else {
                this.addFile = null;
                this.addFilePreview = null;
            }
        },
        async saveAddGem() {
            const formData = new FormData();
            formData.append('name', this.addName || 'No Name');
            formData.append('description', this.addDescription || '');
            formData.append('quota', this.addQuota || '0');

            if (this.addFile) {
                formData.append('image', this.addFile);
            }

            await createGem(formData);

            // Optionally push a new item to the local array
            // (But best practice: you might re-fetch the list from server)
            const newId = this.gemsList.length > 0
                ? Math.max(...this.gemsList.map(gem => gem.id)) + 1
                : 1;

            this.gemsList.push({
                id: newId,
                name: this.addName,
                description: this.addDescription,
                quota: parseInt(this.addQuota) || 0,
                // We can't know the final path from the server 
                // unless we refetch. We'll guess "Unknown" or empty.
                image: this.addFilePreview || '',
            });

            this.isAddOpen = false;
            this.resetAddForm();
        },

        // ------------------------------------------------
        // Methods: View/Edit/Delete
        // ------------------------------------------------
        viewGem(gem) {
            this.selectedGem = JSON.parse(JSON.stringify(gem));
            this.isViewOpen = true;
        },
        editGem(gem) {
            this.selectedGem = JSON.parse(JSON.stringify(gem));
            this.editFile = null;
            this.editFilePreview = null;
            this.isEditOpen = true;
        },
        handleEditFile(event) {
            const file = event.target.files[0];
            if (file) {
                this.editFile = file;
                this.editFilePreview = URL.createObjectURL(file);
            } else {
                this.editFile = null;
                this.editFilePreview = null;
            }
        },
        async saveEditGem() {
            const index = this.gemsList.findIndex(g => g.id === this.selectedGem.id);
            if (index === -1) {
                this.isEditOpen = false;
                this.selectedGem = null;
                return;
            }

            const formData = new FormData();
            formData.append('name', this.selectedGem.name);
            formData.append('description', this.selectedGem.description || '');
            formData.append('quota', this.selectedGem.quota || '0');

            if (this.editFile) {
                formData.append('image', this.editFile);
            }

            await updateGem(this.selectedGem.id, formData);

            // Update local list
            if (this.editFilePreview) {
                this.selectedGem.image = this.editFilePreview;
            }

            this.gemsList[index] = { ...this.selectedGem };

            this.isEditOpen = false;
            this.selectedGem = null;
        },
        confirmDelete(gem) {
            this.selectedGem = { ...gem };
            this.isDeleteOpen = true;
        },
        async deleteGem() {
            await deleteGem(this.selectedGem.id);
            this.gemsList = this.gemsList.filter(g => g.id !== this.selectedGem.id);
            this.isDeleteOpen = false;
            this.selectedGem = null;
        },
        goDetail(gem) {
            // Pindah ke /admin/gems/{gem.id}
            window.location.href = `/admin/gems/${gem.id}`;
        },
    }
}
</script>
@endpush

@section('content')
<div 
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 md:px-8 py-6"
    x-data="manageGems()"
>
    <!-- Header / Title -->
    <h1 class="text-center text-white text-3xl sm:text-4xl md:text-5xl font-im-fell-english mt-4">
        Manage Gems
    </h1>

    <!-- Add Gem Button -->
    <div class="mt-8 bg-abu-abu-keunguan rounded-2xl p-6 sm:p-8">
        <div class="flex justify-center items-center">
            <button
                class="bg-biru-tua rounded-[30px] py-3 sm:py-4 
                       text-white text-lg sm:text-2xl md:text-3xl font-im-fell-english
                       hover:opacity-90 hover:shadow-lg transition w-full max-w-xs"
                @click="isAddOpen = true"
            >
                Add Gem
            </button>
        </div>
    </div>

    <!-- Simple Stats -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Total -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Total
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="gemsList.length"></span>
            </p>
        </div>
        <!-- Highest Quota -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Highest Quota
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="Math.max(...gemsList.map(g => g.quota))"></span>
            </p>
        </div>
        <!-- Lowest Quota -->
        <div class="bg-abu-abu-keunguan rounded-2xl p-4 sm:p-6 flex flex-col items-center">
            <p class="text-biru-tua text-xl sm:text-2xl md:text-3xl font-im-fell-english mb-2">
                Lowest Quota
            </p>
            <p class="text-biru-tua text-4xl sm:text-5xl md:text-6xl font-im-fell-english leading-tight">
                <span x-text="Math.min(...gemsList.map(g => g.quota))"></span>
            </p>
        </div>
    </div>

    <!-- Gem Table -->
    <div class="mt-8 bg-custom-gray rounded-2xl p-4 sm:p-6 md:p-8">
        <!-- Show Entries & Search -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
            <!-- Show Entries -->
            <div class="flex items-center space-x-2 mb-3 md:mb-0">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Show
                </label>
                <input 
                    type="number" 
                    x-model="showEntries"
                    min="1"
                    class="w-16 bg-white border border-black rounded-[10px] p-1 
                           text-center focus:outline-none focus:ring-1 focus:ring-biru-tua text-sm sm:text-base"
                >
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Entries
                </label>
            </div>
            <!-- Search -->
            <div class="flex items-center space-x-2">
                <label class="text-biru-tua text-base sm:text-lg md:text-xl font-im-fell-english">
                    Search
                </label>
                <input 
                    type="text" 
                    x-model="searchTerm"
                    class="bg-white border border-black rounded-[30px] px-3 py-1 
                           focus:outline-none focus:ring-1 focus:ring-biru-tua text-sm sm:text-base"
                    placeholder="Search gem..."
                >
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-black rounded-md overflow-hidden table-auto">
                <thead class="bg-white">
                    <tr class="border-b border-black">
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            No.
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Name
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Image
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Description
                        </th>
                        <th class="py-3 px-3 border-r border-black text-biru-tua 
                                   font-im-fell-english text-sm sm:text-base md:text-lg">
                            Quota
                        </th>
                        <th class="py-3 px-3 text-biru-tua font-im-fell-english 
                                   text-sm sm:text-base md:text-lg">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <template x-for="(gem, i) in paginatedData" :key="gem.id">
                        <tr class="border-b border-black last:border-b-0">
                            <!-- No. -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base">
                                <span x-text="(currentPage - 1) * showEntries + i + 1"></span>.
                            </td>
                            <!-- Gem Name -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.name"
                            ></td>
                            <!-- Image -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base">
                                <template x-if="gem.image">
                                    <img 
                                        :src="gem.image" 
                                        alt="Gem Image" 
                                        class="h-16 w-16 object-cover rounded-md border"
                                    />
                                </template>
                                <template x-if="!gem.image">
                                    <span class="text-gray-400 italic">No Image</span>
                                </template>
                            </td>
                            <!-- Description -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.description"
                            ></td>
                            <!-- Quota -->
                            <td class="py-3 px-3 border-r border-black text-biru-tua 
                                       font-im-fell-english text-sm sm:text-base"
                                x-text="gem.quota"
                            ></td>
                            <!-- Action -->
                            <td class="py-3 px-3 text-biru-tua font-im-fell-english text-sm sm:text-base">
                                <div class="flex flex-wrap gap-2">
                                    <button 
                                        class="bg-hijau-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="viewGem(gem)"
                                    >
                                        View
                                    </button>
                                    <button 
                                        class="bg-biru-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="editGem(gem)"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        class="bg-merah-tua rounded-[15px] px-3 py-1 
                                               text-white hover:opacity-90 hover:shadow-md transition"
                                        @click="confirmDelete(gem)"
                                    >
                                        Erase
                                    </button>
                                    <!-- TOMBOL BARU: Detail -->
                                   <button 
                                        class="bg-abu-abu2 rounded-[15px] px-3 py-1 
                                              text-biru-tua hover:opacity-90 hover:shadow-md transition"
                                                @click="goDetail(gem)"
                                     >
                                        Detail
                                     </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination info -->
        <div class="mt-4 text-sm sm:text-base text-biru-tua" x-text="showingText"></div>

        <!-- Pagination nav -->
        <div class="mt-2 flex items-center space-x-2 text-sm sm:text-base text-biru-tua">
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage <= 1"
                @click="prevPage"
            >
                Previous
            </button>
            <template x-for="page in totalPages" :key="page">
                <button 
                    class="px-2 py-1 border rounded"
                    :class="currentPage === page ? 'bg-biru-tua text-white' : ''"
                    @click="goToPage(page)"
                    x-text="page"
                ></button>
            </template>
            <button 
                class="px-2 py-1 border rounded disabled:opacity-50"
                :disabled="currentPage >= totalPages"
                @click="nextPage"
            >
                Next
            </button>
        </div>
    </div>

    <!-- =============================
         MODALS
    ============================= -->

    <!-- MODAL: Add Gem -->
    <div 
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isAddOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isAddOpen = false; resetAddForm();"
            >
                &times;
            </button>

            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Add Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <!-- Form Add -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                <!-- Name -->
                <div>
                    <label class="block text-xl mb-1 text-white">Name</label>
                    <input 
                        type="text"
                        class="w-full bg-custom-gray rounded-2xl p-3"
                        x-model="addName"
                        placeholder="Gem name..."
                    >
                </div>
                <!-- Quota -->
                <div>
                    <label class="block text-xl mb-1 text-white">Quota</label>
                    <input 
                        type="number"
                        min="0"
                        class="w-full bg-custom-gray rounded-2xl p-3"
                        x-model="addQuota"
                        placeholder="Enter quota..."
                    >
                </div>
                <!-- Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xl mb-1 text-white">Description</label>
                    <textarea 
                        class="w-full bg-custom-gray rounded-2xl p-3 h-24"
                        x-model="addDescription"
                        placeholder="Describe the gem..."
                    ></textarea>
                </div>
                <!-- Image -->
                <div class="sm:col-span-2">
                    <label class="block text-xl mb-1 text-white">Image</label>
                    <input 
                        type="file"
                        accept="image/*"
                        class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                        @change="handleAddFile($event)"
                    >
                    <!-- Optional: Preview -->
                    <template x-if="addFilePreview">
                        <img 
                            :src="addFilePreview" 
                            alt="Preview" 
                            class="mt-3 h-24 w-24 object-cover rounded-md border"
                        />
                    </template>
                </div>
            </div>

            <!-- Save -->
            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveAddGem"
                >
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: View Gem -->
    <div 
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isViewOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isViewOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                View Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedGem">
                <div class="space-y-3 text-lg">
                    <p><strong>ID:</strong> <span x-text="selectedGem.id"></span></p>
                    <p><strong>Name:</strong> <span x-text="selectedGem.name"></span></p>
                    <p><strong>Description:</strong> <span x-text="selectedGem.description"></span></p>
                    <p><strong>Quota:</strong> <span x-text="selectedGem.quota"></span></p>
                    <p>
                        <strong>Image:</strong>
                        <template x-if="selectedGem.image">
                            <img 
                                :src="selectedGem.image" 
                                alt="Gem Image" 
                                class="mt-2 h-24 w-24 object-cover rounded-md border"
                            />
                        </template>
                        <template x-if="!selectedGem.image">
                            <span class="text-gray-200 italic">No Image</span>
                        </template>
                    </p>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL: Edit Gem -->
    <div 
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isEditOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-lg relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isEditOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-3xl sm:text-4xl font-im-fell-english mb-4">
                Edit Gem
            </h2>
            <hr class="border-white/50 mb-6" />

            <template x-if="selectedGem">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-biru-tua">
                    <!-- ID (readonly) -->
                    <div>
                        <label class="block text-xl mb-1 text-white">ID</label>
                        <input 
                            type="text"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.id"
                            readonly
                        >
                    </div>
                    <!-- Name -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Name</label>
                        <input 
                            type="text"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.name"
                        >
                    </div>
                    <!-- Quota -->
                    <div>
                        <label class="block text-xl mb-1 text-white">Quota</label>
                        <input 
                            type="number"
                            min="0"
                            class="w-full bg-custom-gray rounded-2xl p-3"
                            x-model="selectedGem.quota"
                        >
                    </div>
                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label class="block text-xl mb-1 text-white">Description</label>
                        <textarea 
                            class="w-full bg-custom-gray rounded-2xl p-3 h-24"
                            x-model="selectedGem.description"
                        ></textarea>
                    </div>
                    <!-- Current Image -->
                    <div class="sm:col-span-2">
                        <p class="text-white text-xl mb-2">Current Image:</p>
                        <template x-if="selectedGem.image && !editFilePreview">
                            <img 
                                :src="selectedGem.image"
                                alt="Gem Image"
                                class="h-24 w-24 object-cover rounded-md border mb-2"
                            />
                        </template>
                        <template x-if="editFilePreview">
                            <img 
                                :src="editFilePreview"
                                alt="New Preview"
                                class="h-24 w-24 object-cover rounded-md border mb-2"
                            />
                        </template>
                        <template x-if="!selectedGem.image && !editFilePreview">
                            <span class="text-gray-200 italic">No Image</span>
                        </template>
                    </div>
                    <!-- Upload New Image -->
                    <div class="sm:col-span-2">
                        <label class="block text-xl mb-1 text-white">Update Image (Optional)</label>
                        <input 
                            type="file"
                            accept="image/*"
                            class="w-full bg-custom-gray rounded-2xl p-3 text-biru-tua"
                            @change="handleEditFile($event)"
                        >
                    </div>
                </div>
            </template>

            <div class="mt-6 flex justify-end">
                <button 
                    class="bg-abu-abu-keunguan text-biru-tua px-6 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="saveEditGem"
                >
                    Update
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Confirm Delete -->
    <div 
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        x-show="isDeleteOpen"
        x-transition
    >
        <div class="bg-biru-tua text-white rounded-2xl p-6 sm:p-8 w-[90%] max-w-md relative">
            <button 
                class="absolute top-3 right-3 text-2xl font-bold"
                @click="isDeleteOpen = false; selectedGem = null;"
            >
                &times;
            </button>
            <h2 class="text-2xl sm:text-3xl font-im-fell-english mb-4">
                Are you sure?
            </h2>
            <hr class="border-white/50 mb-6" />

            <p class="mb-6">
                You are about to <span class="font-semibold text-red-300">delete</span> Gem 
                with ID: <span class="font-bold" x-text="selectedGem?.id"></span>. 
                This action cannot be undone.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    class="bg-gray-300 text-biru-tua px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="isDeleteOpen = false; selectedGem = null;"
                >
                    Cancel
                </button>
                <button
                    class="bg-red-600 text-white px-4 py-2 rounded-2xl hover:opacity-90 transition"
                    @click="deleteGem"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

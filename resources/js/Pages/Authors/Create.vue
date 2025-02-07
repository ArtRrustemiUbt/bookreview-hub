<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
    name: '',
    bio: '',
    photo: null,
    website: '',
    twitter: '',
    facebook: '',
    instagram: '',
});

const createAuthor = () => {
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('bio', form.value.bio);
    if (form.value.photo) formData.append('photo', form.value.photo);
    formData.append('website', form.value.website);
    formData.append('twitter', form.value.twitter);
    formData.append('facebook', form.value.facebook);
    formData.append('instagram', form.value.instagram);

    router.post(route('authors.store'), formData);
};
</script>

<template>
    <Head title="Create Author" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add New Author
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form @submit.prevent="createAuthor" class="bg-white p-6 shadow-md rounded" enctype="multipart/form-data">
               
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Author Name</label>
                    <input v-model="form.name" type="text" class="border rounded w-full px-3 py-2" required />
                </div>

               
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Biography</label>
                    <textarea v-model="form.bio" class="border rounded w-full px-3 py-2" rows="4"></textarea>
                </div>

                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Author Photo</label>
                    <input @change="e => form.photo = e.target.files[0]" type="file" accept="image/*" class="border rounded w-full px-3 py-2" />
                </div>

               
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Website</label>
                    <input v-model="form.website" type="url" class="border rounded w-full px-3 py-2" />
                </div>

                
                <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Twitter</label>
                        <input v-model="form.twitter" type="url" class="border rounded w-full px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Facebook</label>
                        <input v-model="form.facebook" type="url" class="border rounded w-full px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Instagram</label>
                        <input v-model="form.instagram" type="url" class="border rounded w-full px-3 py-2" />
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Author</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { defineProps, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    author: Object,
});

const form = ref({
    name: props.author.name,
    bio: props.author.bio || '',
    website: props.author.website || '',
    twitter: props.author.twitter || '',
    facebook: props.author.facebook || '',
    instagram: props.author.instagram || '',
    photo: null,
});

const updateAuthor = () => {
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('bio', form.value.bio);
    formData.append('website', form.value.website);
    formData.append('twitter', form.value.twitter);
    formData.append('facebook', form.value.facebook);
    formData.append('instagram', form.value.instagram);
    if (form.value.photo) formData.append('photo', form.value.photo);

    formData.append('_method', 'PUT');

    router.post(route('authors.update', props.author.id), formData, {
        forceFormData: true,
    });
};

</script>

<template>
    <Head title="Edit Author" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Author
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form @submit.prevent="updateAuthor" class="bg-white p-6 shadow-md rounded" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Author Name</label>
                    <input v-model="form.name" type="text" class="border rounded w-full px-3 py-2" required />
                </div>

                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Biography</label>
                    <textarea v-model="form.bio" class="border rounded w-full px-3 py-2" rows="4"></textarea>
                </div>

                
                <div v-if="props.author.photo" class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Current Photo</label>
                    <img :src="props.author.photo" alt="Author Photo" class="w-32 h-32 object-cover rounded mb-2" />
                </div>

                
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Upload New Photo</label>
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

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Author</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

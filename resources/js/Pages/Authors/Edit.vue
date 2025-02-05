<script setup>
import { defineProps, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    author: Object, // Receiving author data from Laravel
});

const form = ref({
    name: props.author.name,
});

const updateAuthor = () => {
    router.put(route('authors.update', props.author.id), form.value);
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
            <form @submit.prevent="updateAuthor" class="bg-white p-6 shadow-md rounded">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Author Name</label>
                    <input v-model="form.name" type="text" class="border rounded w-full px-3 py-2" required />
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Author</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

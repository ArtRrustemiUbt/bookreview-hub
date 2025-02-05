<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
    name: '',
});

const createAuthor = () => {
    router.post(route('authors.store'), form.value);
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
            <form @submit.prevent="createAuthor" class="bg-white p-6 shadow-md rounded">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Author Name</label>
                    <input v-model="form.name" type="text" class="border rounded w-full px-3 py-2" required />
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Author</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

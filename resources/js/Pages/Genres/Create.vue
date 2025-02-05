<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
    name: '',
});

const createGenre = () => {
    router.post(route('genres.store'), form.value);
};
</script>

<template>
    <Head title="Add New Genre" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add New Genre
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form @submit.prevent="createGenre">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Genre Name</label>
                        <input v-model="form.name" type="text" class="w-full border rounded-lg px-4 py-2" required />
                    </div>

                    <div class="flex items-center justify-between">
                        <Link :href="route('genres.index')" class="text-gray-500">Cancel</Link>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                            Create Genre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

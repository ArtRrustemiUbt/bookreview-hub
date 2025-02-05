<script setup>
import { defineProps } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    genres: Array, // Receiving genres from Laravel
});

const deleteGenre = (id) => {
    if (confirm('Are you sure you want to delete this genre?')) {
        router.delete(route('genres.destroy', id));
    }
};
</script>

<template>
    <Head title="Genres" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Genre List
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-4">
                <Link :href="route('genres.create')" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add New Genre
                </Link>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Genre Name</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="genre in genres" :key="genre.id" class="border border-gray-300">
                        <td class="px-4 py-2">{{ genre.name }}</td>
                        <td class="px-4 py-2">
                            <Link :href="route('genres.edit', genre.id)" class="text-blue-500 mr-2">Edit</Link>
                            <button @click="deleteGenre(genre.id)" class="text-red-500">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

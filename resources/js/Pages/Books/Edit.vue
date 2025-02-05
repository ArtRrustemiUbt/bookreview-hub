<script setup>
import { defineProps, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    book: Object,
    authors: Array,
    genres: Array, // Receive genres from Laravel
});

const form = ref({
    title: props.book.title,
    author_id: props.book.author_id,
    genre_id: props.book.genre_id, // Pre-fill genre selection
    description: props.book.description,
});

const updateBook = () => {
    router.put(route('books.update', props.book.id), form.value);
};
</script>

<template>
    <Head title="Edit Book" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Book
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form @submit.prevent="updateBook">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Title</label>
                        <input v-model="form.title" type="text" class="w-full border rounded-lg px-4 py-2" required />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Author</label>
                        <select v-model="form.author_id" class="w-full border rounded-lg px-4 py-2">
                            <option v-for="author in authors" :key="author.id" :value="author.id">
                                {{ author.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium">Genre</label>
                        <select v-model="form.genre_id" class="w-full border rounded-lg px-4 py-2">
                            <option v-for="genre in genres" :key="genre.id" :value="genre.id">
                                {{ genre.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between">
                        <Link :href="route('books.index')" class="text-gray-500">Cancel</Link>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                            Update Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

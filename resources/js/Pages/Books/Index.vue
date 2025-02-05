<script setup>
import { defineProps } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    books: Array, // Receive books with authors from Laravel
});

const deleteBook = (id) => {
    if (confirm('Are you sure you want to delete this book?')) {
        router.delete(route('books.destroy', id));
    }
};
</script>

<template>
    <Head title="Books" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Books List
            </h2>
        </template>
        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="mb-4">
                <Link :href="route('books.create')" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add New Book
                </Link>
            </div>

            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Title</th>
                        <th class="border border-gray-300 px-4 py-2">Author</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in books" :key="book.id" class="border border-gray-300">
                        <td class="px-4 py-2">{{ book.title }}</td>
                        <td class="px-4 py-2">{{ book.author?.name || 'No Author Assigned' }}</td>
                        <td class="px-4 py-2">
                            {{ book.description.length > 50 ? book.description.slice(0, 50) + '...' : book.description }}
                        </td>
                        <td class="px-4 py-2">
                            <Link :href="route('books.edit', book.id)" class="text-blue-500 mr-2">Edit</Link>
                            <button @click="deleteBook(book.id)" class="text-red-500">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

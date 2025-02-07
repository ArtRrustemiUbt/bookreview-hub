<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue'; // Import the Navbar
import { defineProps } from 'vue';

defineProps({
    books: Array,
});
</script>

<template>
    <Head title="Home" />

    <!-- Navbar for the Home Page -->
    <Navbar />

    <!-- Home Page Content -->
    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Latest Books</h1>

        <div v-if="books.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="book in books" :key="book.id" class="bg-white p-4 rounded-lg shadow">
                <img v-if="book.cover_image" :src="book.cover_image" alt="Cover" class="w-full h-48 object-cover mb-4 rounded" />
                <h2 class="text-lg font-semibold">{{ book.title }}</h2>
                <p class="text-gray-600">{{ book.author?.name || 'No Author' }}</p>
                <p class="text-sm text-gray-500">{{ book.genre?.name || 'No Genre' }}</p>
                <p class="text-gray-700 mt-2">
                    {{ book.description.length > 100 ? book.description.slice(0, 100) + '...' : book.description }}
                </p>
                <Link :href="route('books.show', book.id)" class="text-blue-500 mt-4 inline-block">Read More</Link>
            </div>
        </div>

        <div v-else>
            <p class="text-center text-gray-500">No books available.</p>
        </div>
    </div>
</template>

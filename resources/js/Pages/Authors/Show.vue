<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import { defineProps } from 'vue';

const props = defineProps({
    author: Object
});
</script>

<template>
    <Head :title="props.author.name" />
    <Navbar />

    <div class="py-12 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <img v-if="props.author.photo" 
                 :src="props.author.photo" 
                 alt="Author Photo" 
                 class="w-48 h-48 object-cover rounded-full mx-auto mb-4" />

            <h1 class="text-3xl font-bold mb-2">{{ props.author.name }}</h1>
            <p class="text-gray-700 mb-4">{{ props.author.bio || 'No biography available.' }}</p>

            <div class="flex justify-center space-x-4 mt-4">
                <a v-if="props.author.website" :href="props.author.website" target="_blank" class="text-blue-500">Website</a>
                <a v-if="props.author.twitter" :href="props.author.twitter" target="_blank" class="text-blue-500">Twitter</a>
                <a v-if="props.author.facebook" :href="props.author.facebook" target="_blank" class="text-blue-500">Facebook</a>
                <a v-if="props.author.instagram" :href="props.author.instagram" target="_blank" class="text-blue-500">Instagram</a>
            </div>
        </div>

        <div class="bg-white p-6 mt-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Books by {{ props.author.name }}</h2>

            <div v-if="props.author.books.length" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div v-for="book in props.author.books" :key="book.id" class="bg-gray-50 p-4 rounded-lg shadow">
                    <img v-if="book.cover_image" 
                         :src="book.cover_image" 
                         alt="Book Cover" 
                         class="w-full h-48 object-cover mb-4 rounded" />
                    <h3 class="text-lg font-semibold">{{ book.title }}</h3>
                    <p class="text-sm text-gray-500">{{ book.genre?.name || 'No Genre' }}</p>
                    <Link :href="route('books.show', book.id)" class="text-blue-500 mt-2 inline-block">View Book</Link>
                </div>
            </div>

            <div v-else>
                <p class="text-gray-500">No books found for this author.</p>
            </div>
        </div>
    </div>
</template>

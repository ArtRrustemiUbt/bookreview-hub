<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue'; 
import AuthorSidebar from '@/Components/AuthorSidebar.vue';  // Import the Sidebar Component
import { defineProps, ref } from 'vue';

const props = defineProps({
    books: Object,
    authors: Array,
    filters: Object,
});

const search = ref(props.filters.search || '');
const sortBy = ref(props.filters.sort_by || '');
const selectedAuthorId = ref(props.filters.author_id || '');

const submitSearch = () => {
    router.get(route('books.all'), { 
        search: search.value, 
        sort_by: sortBy.value, 
        author_id: selectedAuthorId.value 
    }, { 
        preserveState: true, 
        replace: true 
    });
};

const handleAuthorFilter = (authorId) => {
    selectedAuthorId.value = authorId;
    submitSearch();
};

const navigate = (url) => {
    router.visit(url);
};
</script>

<template>
    <Head title="All Books" />

    <Navbar />

    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8 flex">
        <AuthorSidebar 
            :authors="authors" 
            :selectedAuthorId="selectedAuthorId" 
            @filterAuthor="handleAuthorFilter" 
        />

        <div class="w-3/4">
            <h1 class="text-3xl font-bold mb-6 text-center">All Books</h1>

            <div class="mb-6 flex justify-center space-x-4">
                <input 
                    v-model="search" 
                    @keyup.enter="submitSearch" 
                    type="text" 
                    placeholder="Search by book title..." 
                    class="border rounded-lg p-2 w-1/2"
                />
                <button @click="submitSearch" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Search
                </button>

                <select v-model="sortBy" @change="submitSearch" class="border rounded-lg p-2 w-[100px]">
                    <option value="">Sort By</option>
                    <option value="author">Author</option>
                    <option value="genre">Genre</option>
                </select>
            </div>

            <div v-if="books.data.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="book in books.data" :key="book.id" class="bg-white p-4 rounded-lg shadow">
                    <img v-if="book.cover_image" 
                         :src="book.cover_image" 
                         alt="Cover" 
                         class="w-full h-48 object-cover mb-4 rounded" />
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
                <p class="text-center text-gray-500">No books found.</p>
            </div>

            <div class="mt-8 flex justify-center">
                <button v-if="books.prev_page_url" 
                        @click="navigate(books.prev_page_url)" 
                        class="px-4 py-2 bg-gray-300 rounded-l hover:bg-gray-400">
                    Previous
                </button>
                <button v-if="books.next_page_url" 
                        @click="navigate(books.next_page_url)" 
                        class="px-4 py-2 bg-gray-300 rounded-r hover:bg-gray-400">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    authors: Array,
    selectedAuthorId: Number 
});

const emit = defineEmits(['filterAuthor']);

const selectAuthor = (authorId) => {
    emit('filterAuthor', authorId);
};
</script>

<template>
    <aside class="w-1/4 bg-white p-4 rounded-lg shadow-lg mr-6">
        <h2 class="text-xl font-bold mb-4">Authors</h2>

        <ul>
            <li 
                v-for="author in authors" 
                :key="author.id"
                @click="selectAuthor(author.id)"
                :class="author.id === selectedAuthorId ? 'text-blue-500 font-semibold' : 'text-gray-700'"
                class="cursor-pointer hover:text-blue-500 mb-2"
            >
                {{ author.name }}
            </li>
        </ul>

        <button v-if="selectedAuthorId" 
                @click="selectAuthor(null)" 
                class="mt-4 bg-red-500 text-white px-4 py-2 rounded">
            Clear Author Filter
        </button>
    </aside>
</template>

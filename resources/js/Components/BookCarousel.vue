<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    books: Array,
});

const currentSlide = ref(0);
let interval = null;

onMounted(() => {
    startAutoSlide();
});

const startAutoSlide = () => {
    interval = setInterval(() => {
        nextSlide();
    }, 3000);
};

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % props.books.length;
};

</script>

<template>
    <div class="relative w-full overflow-hidden">
        <div class="flex transition-transform duration-700 ease-in-out" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div v-for="(book, index) in books" :key="index" class="w-full flex-shrink-0 relative">
                <img v-if="book.cover_image" :src="book.cover_image" :alt="book.title" class="w-full h-[600px] object-cover" />

                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                    <h3 class="text-2xl font-semibold">{{ book.title }}</h3>
                    <p class="text-lg">{{ book.author?.name || 'Unknown Author' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

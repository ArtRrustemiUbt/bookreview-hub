<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import { defineProps, ref, computed } from 'vue';

const props = defineProps({
    book: Object,
    userReview: Object,
});

const newReview = ref({
    stars: 0,
    comment: '',
});

const showAllReviews = ref(false);

const displayedReviews = computed(() => {
    return showAllReviews.value ? props.book.reviews : props.book.reviews.slice(0, 5);
});

const submitReview = () => {
    if (newReview.value.stars === 0) {
        alert('Please select a star rating.');
        return;
    }

    router.post(route('reviews.store'), {
        book_id: props.book.id,
        stars: newReview.value.stars,
        comment: newReview.value.comment,
    }, {
        onSuccess: () => {
            newReview.value.stars = 0;
            newReview.value.comment = '';
            location.reload();
        }
    });
};
</script>

<template>
    <Head :title="props.book.title" />
    <Navbar />

    <div class="py-12 mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex flex-col md:flex-row">
                
                <img v-if="props.book.cover_image" 
                     :src="props.book.cover_image.startsWith('http') ? props.book.cover_image : '/storage/' + props.book.cover_image" 
                     alt="Cover Image" 
                     class="w-full md:w-1/3 object-cover rounded-lg mb-4 md:mb-0 md:mr-6 h-[600px]" />
                
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ props.book.title }}</h1>
                    
                    <p class="text-lg text-gray-700 mb-1">
                        Author: 
                        <Link v-if="props.book.author" 
                            :href="route('authors.show', props.book.author.id)" 
                            class="font-medium text-blue-500 hover:underline">
                            {{ props.book.author.name }}
                        </Link>
                        <span v-else class="font-medium">No Author</span>
                    </p>

                    <div class="flex items-center mt-4">
                        <span class="text-lg font-semibold text-gray-700 mr-2">Average Rating:</span>
                        <div class="flex items-center">
                            <span v-for="star in 5" :key="star" class="text-xl"
                                  :class="star <= Math.round(props.book.average_rating) ? 'text-yellow-400' : 'text-gray-300'">
                                ★
                            </span>
                            <span class="ml-2 text-lg text-gray-700">({{ props.book.average_rating }}/5)</span>
                        </div>
                    </div>

                    <p class="text-lg text-gray-700 mt-4">Description:</p>
                    <p class="text-gray-600">{{ props.book.description }}</p>
                    <Link :href="route('home')" class="text-blue-500 mt-6 inline-block">Back to Book List</Link>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 mt-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Leave a Review</h2>

            <div v-if="!props.userReview">
                <div class="flex items-center mb-4">
                    <span v-for="star in 5" :key="star" 
                          @click="newReview.stars = star" 
                          class="cursor-pointer text-3xl"
                          :class="star <= newReview.stars ? 'text-yellow-400' : 'text-gray-300'">
                        ★
                    </span>
                </div>
                <textarea v-model="newReview.comment" 
                          placeholder="Leave a comment..." 
                          class="w-full p-4 border rounded-lg mb-4" 
                          rows="4"></textarea>
                <button @click="submitReview" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Submit Review
                </button>
            </div>

            <div v-else>
                <p class="text-green-500 font-semibold">You have already reviewed this book.</p>
                <div class="flex items-center mb-2 mt-4">
                    <span v-for="star in 5" :key="star" class="text-2xl"
                          :class="star <= props.userReview.stars ? 'text-yellow-400' : 'text-gray-300'">
                        ★
                    </span>
                </div>
                <p class="text-gray-700">{{ props.userReview.comment }}</p>
            </div>
        </div>

        <div class="bg-white p-6 mt-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Reviews</h2>
            <div v-if="props.book.reviews.length">
                <div v-for="review in displayedReviews" :key="review.id" class="border-b border-gray-200 pb-4 mb-4">
                    <div class="flex items-center mb-2">
                        <span v-for="star in 5" :key="star" class="text-xl"
                              :class="star <= review.stars ? 'text-yellow-400' : 'text-gray-300'">
                            ★
                        </span>
                    </div>
                    <p class="text-gray-700 mb-2">{{ review.comment }}</p>
                    <p class="text-sm text-gray-500">Reviewed by {{ review.user }} • {{ review.created_at }}</p>
                </div>
                <div v-if="props.book.reviews.length > 5" class="text-center mt-4">
                    <button @click="showAllReviews = !showAllReviews"
                            class="text-blue-500 font-medium">
                        {{ showAllReviews ? 'Show Less' : 'Show More' }}
                    </button>
                </div>
            </div>
            <div v-else>
                <p class="text-gray-500">No reviews yet. Be the first to review!</p>
            </div>
        </div>
    </div>
</template>


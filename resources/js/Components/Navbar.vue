<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const isOpen = ref(false);
const page = usePage();

// Extract props from Inertia shared data
const isAuthenticated = computed(() => page.props.auth.user?.isAuthenticated || false);
const userRole = computed(() => page.props.auth.user?.role || null);

// Debugging
console.log("User Authenticated:", isAuthenticated.value);

const logout = () => {
    router.post(route('logout'), {}, {
        preserveScroll: true,
        onSuccess: () => console.log("Logged out successfully"),
        onError: (errors) => console.error("Logout error:", errors)
    });
};
</script>


<template>
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <Link :href="route('home')" class="text-xl font-bold text-blue-600">
                        BookReview Hub
                    </Link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:space-x-6 gap-6">
                    <Link :href="route('home')" class="text-gray-700 hover:text-blue-600">Home</Link>
                    <!--<Link :href="route('books.index')" class="text-gray-700 hover:text-blue-600">Books</Link> -->
                   <!-- <Link v-if="userRole === 'admin'" :href="route('books.create')" class="text-gray-700 hover:text-blue-600">Add Book</Link>-->
                    <Link :href="route('books.all')" class="text-gray-700 hover:text-blue-600">
                        View All Books
                    </Link>

                    <Link v-if="userRole === 'admin'" :href="route('admin.notifications')" class="relative text-gray-700 hover:text-blue-600">
                        Notifications
                        <span v-if="notificationsCount > 0"
                              class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full px-2">
                            {{ notificationsCount }}
                        </span>
                    </Link>
                </div>

                <div class="sm:hidden flex items-center">
                    <button @click="isOpen = !isOpen" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg v-if="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div v-if="isOpen" class="sm:hidden bg-white shadow-md">
                    <div class="px-4 pt-2 pb-4 space-y-2">
                        <Link :href="route('books.index')" class="block text-gray-700 hover:text-blue-600">Books</Link>
                        <Link :href="route('books.create')" class="block text-gray-700 hover:text-blue-600">Add Book</Link>

                        <Link v-if="userRole === 'admin'" :href="route('admin.notifications')" class="block text-gray-700 hover:text-blue-600">
                            Notifications
                            <span v-if="notificationsCount > 0"
                                class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full px-2">
                                {{ notificationsCount }}
                            </span>
                        </Link>
                    </div>
                </div>

                <div v-if="!isAuthenticated" class="flex items-center space-x-2">
                    <Link :href="route('register')" class="px-4 py-2 text-sm font-medium text-cyan-600 bg-cyan-100 rounded-md hover:bg-cyan-200">
                        Register
                    </Link>
                    <Link :href="route('login')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Login
                    </Link>
                </div>

                <div v-if="isAuthenticated" class="flex items-center">
                    <form @submit.prevent="logout">
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        

        

        
    </nav>
</template>


<style scoped>
/* Optional: Add custom styles if needed */
</style>

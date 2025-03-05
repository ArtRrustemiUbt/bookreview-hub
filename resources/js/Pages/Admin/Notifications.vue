<script setup>
import { defineProps } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    notifications: Array // Receive notifications from Laravel
});

const markAsRead = (id) => {
    router.post(`/admin/notifications/read/${id}`, {}, {
        onSuccess: () => {
            location.reload();
        }
    });
};
</script>

<template>
    <Head title="Admin Notifications" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin Notifications
            </h2>
        </template>

        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <ul v-if="notifications.length > 0">
                    <li v-for="notification in notifications" :key="notification.id"
                        class="border-b py-4 last:border-none">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-800 font-medium">{{ notification.message }}</p>
                                <div class="text-sm text-gray-500">
                                    <p>📚 Book ID: {{ notification.data.book_id }}</p>
                                    <p>👤 User ID: {{ notification.data.user_id }}</p>
                                    <p>⭐ Rating: {{ notification.data.stars }}</p>
                                    <p>💬 Comment: "{{ notification.data.comment }}"</p>
                                </div>
                            </div>
                            <button @click="markAsRead(notification.id)"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                                Mark as Read
                            </button>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-600 text-center">No new notifications.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

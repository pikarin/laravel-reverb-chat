<script setup>
defineProps({
    userId: Number,
    message: Object,
});
</script>

<template>
    <div class="flex flex-wrap" :class="{ 'justify-end': userId == message.user_id }">
        <div class="md:w-1/2 pr-4 pl-4">
            <small class="text-gray-700">
                <strong>{{ message.user.name }} | </strong>
            </small>
            <small class="text-gray-700 float-right">
                {{ message.time }}
            </small>
            <div class="relative px-3 py-3 mb-4 border rounded bg-blue-200 border-blue-300 text-blue-800">{{ message.body }}</div>
        </div>
    </div>
</template>

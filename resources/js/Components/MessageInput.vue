<script setup>
import axios from 'axios';
import { ref } from 'vue';

const message = ref('');

const messageRequest = async (text) => {
    try {
        await axios.post(`/message`, {
            text: text.value
        });
    } catch (err) {
        console.log(err.message);
    }
}

const sendMessage = (e) => {
    e.preventDefault();

    if (message.value.trim() === '' ) {
        alert('Please enter a message!');

        return;
    }

    messageRequest(message);
    message.value = '';
}
</script>

<template>
    <div class="relative flex items-stretch w-full">
        <input
            type="text"
            v-model="message"
            autocomplete="off"
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
            placeholder="Message..."
        />

        <div class="input-group-append">
            <button
                @click="sendMessage"
                class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"
                type="button"
            >
                Send
            </button>
        </div>
    </div>
</template>

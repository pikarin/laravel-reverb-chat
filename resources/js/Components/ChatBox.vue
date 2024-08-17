<script setup>
import axios from 'axios';
import { onMounted, onUnmounted, ref } from 'vue';
import Message from './Message.vue';
import MessageInput from './MessageInput.vue';

const webSocketChannel = `channel_for_everyone`;

const messages = ref([]);

const scroll = ref(null);

const scrollToBottom = () => {
    scroll.value.scrollIntoView({ behaviour: "smooth" });
}

const connectWebSocket = () => {
    window.Echo.private(webSocketChannel)
        .listen('GotMessage', async (e) => {
            await getMessages();
        });
}

const getMessages = async () => {
    try {
        const m = await axios.get(`/messages`);

        messages.value = m.data;

        setTimeout(scrollToBottom, 0);
    } catch (err) {
        console.log(err);
    }
}

onMounted(() => {
    getMessages();
    connectWebSocket();
});

onUnmounted(() => {
    window.Echo.leave(webSocketChannel);
});
</script>

<template>
    <div class="flex justify-center">
    <div class="w-full md:w-2/3 lg:w-1/2">
      <div class="bg-white shadow rounded-lg">
        <div class="bg-gray-100 p-4 border-b border-gray-200">Chat Box</div>
        <div class="p-4 h-96 overflow-y-auto">
          <Message
            v-for="message in messages"
            :key="message.id"
            :user-id="$page.props.auth.user.id"
            :message="message"
          />
          <span ref="scroll"></span>
        </div>
        <div class="p-4 border-t border-gray-200">
          <MessageInput />
        </div>
      </div>
    </div>
  </div>
</template>

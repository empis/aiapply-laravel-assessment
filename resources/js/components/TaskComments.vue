<template>
  <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Comments</h2>

    <!-- Comment list -->
    <div v-if="comments.length > 0" class="space-y-4 mb-6">
      <div v-for="comment in comments" :key="comment.id" class="flex gap-3">
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-sm font-semibold">
          {{ comment.user.name.charAt(0).toUpperCase() }}
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-baseline gap-2">
            <span class="text-sm font-semibold text-gray-900">{{ comment.user.name }}</span>
            <span class="text-xs text-gray-400">{{ formatDate(comment.created_at) }}</span>
          </div>
          <p class="mt-1 text-sm text-gray-700 whitespace-pre-wrap">{{ comment.body }}</p>
        </div>
      </div>
    </div>
    <p v-else class="text-gray-400 text-sm italic mb-6">No comments yet. Be the first to comment.</p>

    <!-- Add comment form -->
    <form @submit.prevent="submitComment" class="space-y-3">
      <div>
        <textarea
          v-model="commentBody"
          rows="3"
          placeholder="Write a comment…"
          class="block w-full px-3 py-2 border rounded-md shadow-sm text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
          :class="commentError ? 'border-red-400' : 'border-gray-300'"
        ></textarea>
        <p v-if="commentError" class="mt-1 text-xs text-red-600">{{ commentError }}</p>
      </div>
      <div class="flex justify-end">
        <button
          type="submit"
          :disabled="submitting"
          class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        >
          {{ submitting ? 'Posting…' : 'Post comment' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../composables/useApi.js';
import { formatDate } from '../utils/date.js';

const props = defineProps({
  taskId: { type: [Number, String], required: true },
});

const comments = ref([]);
const commentBody = ref('');
const commentError = ref('');
const submitting = ref(false);


const fetchComments = async () => {
  try {
    const response = await api.get(`/tasks/${props.taskId}/comments`);
    comments.value = response.data;
  } catch (err) {
    console.error('Failed to fetch comments:', err);
  }
};

const submitComment = async () => {
  commentError.value = '';
  if (!commentBody.value.trim()) {
    commentError.value = 'Comment body is required.';
    return;
  }
  submitting.value = true;
  try {
    const response = await api.post(`/tasks/${props.taskId}/comments`, { body: commentBody.value });
    comments.value.unshift(response.data);
    commentBody.value = '';
  } catch (err) {
    const errors = err.response?.data?.errors?.body;
    commentError.value = errors ? errors[0] : 'Failed to post comment.';
  } finally {
    submitting.value = false;
  }
};

onMounted(fetchComments);
</script>

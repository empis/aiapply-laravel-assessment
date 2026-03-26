<template>
  <div class="min-h-full">
    <!-- Navigation bar (only when authenticated) -->
    <nav v-if="isAuthenticated" class="bg-white border-b border-gray-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Brand + nav links -->
          <div class="flex items-center space-x-8">
            <router-link to="/" class="text-xl font-bold text-primary-600 tracking-tight">
              TaskManager
            </router-link>
            <router-link
              to="/"
              class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors"
              :class="$route.path === '/' ? 'border-primary-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
            >
              Tasks
            </router-link>
            <router-link
              to="/tasks/create"
              class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors"
              :class="$route.path === '/tasks/create' ? 'border-primary-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
            >
              New Task
            </router-link>
          </div>

          <!-- User info + logout -->
          <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-700">{{ user?.name }}</span>
            <button
              @click="handleLogout"
              class="text-sm text-gray-500 hover:text-red-600 font-medium transition-colors px-3 py-1 rounded-md hover:bg-red-50"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Guest nav (login/register links) -->
    <nav v-else class="bg-white border-b border-gray-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <span class="text-xl font-bold text-primary-600 tracking-tight">TaskManager</span>
          <div class="flex items-center space-x-4">
            <router-link
              to="/login"
              class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors"
            >
              Login
            </router-link>
            <router-link
              to="/register"
              class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md transition-colors"
            >
              Register
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Notification toasts -->
    <div class="fixed top-4 right-4 z-50 space-y-2 pointer-events-none">
      <div
        v-for="notification in notifications"
        :key="notification.id"
        class="flex items-start gap-3 bg-white rounded-lg shadow-lg border border-gray-200 p-4 w-80 pointer-events-auto"
      >
        <div class="flex-1 text-sm text-gray-700">{{ notification.message }}</div>
        <button @click="dismiss(notification.id)" class="text-gray-400 hover:text-gray-600 flex-shrink-0 text-xs leading-none mt-0.5">✕</button>
      </div>
    </div>

    <!-- Main content -->
    <main>
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { onUnmounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from './composables/useAuth.js';
import { useNotifications } from './composables/useNotifications.js';
import echo from './echo.js';

const router = useRouter();
const { isAuthenticated, user, logout } = useAuth();
const { notifications, add: addNotification, dismiss } = useNotifications();

let channel = null;

const subscribeToUserChannel = (userId) => {
  channel = echo.private(`App.Models.User.${userId}`);
  channel.listen('CommentCreated', (event) => {
    addNotification(`${event.commenter.name} commented on "${event.task.name}"`);
  });
};

const unsubscribeFromUserChannel = () => {
  if (channel && user.value?.id) {
    echo.leave(`App.Models.User.${user.value.id}`);
    channel = null;
  }
};

watch(
  () => user.value?.id,
  (userId) => {
    unsubscribeFromUserChannel();
    if (userId) subscribeToUserChannel(userId);
  },
  { immediate: true },
);

onUnmounted(unsubscribeFromUserChannel);

const handleLogout = async () => {
  unsubscribeFromUserChannel();
  await logout();
  router.push({ name: 'Login' });
};
</script>

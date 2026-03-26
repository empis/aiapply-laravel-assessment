<template>
  <div class="mt-4 flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <input
        :value="name"
        @input="$emit('update:name', $event.target.value)"
        type="text"
        placeholder="Search tasks…"
        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500"
      />
    </div>
    <div>
      <select
        :value="status"
        @change="$emit('update:status', $event.target.value)"
        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500"
      >
        <option value="">All Statuses</option>
        <option value="todo">To Do</option>
        <option value="in_progress">In Progress</option>
        <option value="done">Done</option>
      </select>
    </div>
  </div>
</template>

<script setup>
defineProps({
  name: { type: String, default: '' },
  status: { type: String, default: '' },
});

const emit = defineEmits(['update:name', 'update:status']);
</script>

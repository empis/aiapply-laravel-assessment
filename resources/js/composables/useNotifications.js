import { ref } from 'vue';

const notifications = ref([]);
let nextId = 0;

export function useNotifications() {
    const add = (message) => {
        const id = nextId++;
        notifications.value.push({ id, message });
        setTimeout(() => dismiss(id), 5000);
    };

    const dismiss = (id) => {
        notifications.value = notifications.value.filter((n) => n.id !== id);
    };

    return { notifications, add, dismiss };
}

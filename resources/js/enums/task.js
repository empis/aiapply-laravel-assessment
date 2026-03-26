const { taskStatus, taskPriority } = window.ENUMS;

export const TaskStatus = {
    values: taskStatus,
    classes: {
        todo: 'bg-gray-100 text-gray-700',
        in_progress: 'bg-yellow-100 text-yellow-800',
        done: 'bg-green-100 text-green-800',
    },
    label: (value) => taskStatus.find((s) => s.value === value)?.label ?? value,
    class: (value) => TaskStatus.classes[value] ?? 'bg-gray-100 text-gray-700',
};

export const TaskPriority = {
    values: taskPriority,
    classes: {
        low: 'bg-blue-100 text-blue-800',
        medium: 'bg-orange-100 text-orange-800',
        high: 'bg-red-100 text-red-800',
    },
    label: (value) => taskPriority.find((p) => p.value === value)?.label ?? value,
    class: (value) => TaskPriority.classes[value] ?? 'bg-gray-100 text-gray-700',
};

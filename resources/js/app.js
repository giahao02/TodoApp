import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
// import persist from '@alpinejs/persist'

window.Alpine = Alpine;
// Alpine.plugin(persist);

document.addEventListener('alpine:init', () => {
    Alpine.data('todoApp', () => ({
        listTodo: [],
        allTodos: [],
        newTodo: '',
        search: '',
        state: { total: 0, completed: 0, filter: 'all' },
        notification: {
            show: false,
            message: '',
            type: '',
        },

        showNotification(message, type = 'success') {
            this.notification.message = message;
            this.notification.type = type;
            this.notification.show = true;

            setTimeout(() => {
                this.notification.show = false;
            }, 3000);
        },

        fetchTodos() {
            const hasSearch = this.search.trim() !== '';
            const url = hasSearch
                ? `/api/todos?search=${encodeURIComponent(this.search)}`
                : '/api/todos';
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        console.log(this.list);
                        if (hasSearch) {
                            this.listTodo = res.data;
                        } else {
                            this.allTodos = res.data;
                            this.listTodo = res.data;
                            this.taskCounts();
                        }
                    } else {
                        this.showNotification(res.message || 'Failed to load task', 'error');
                    }
                })
                .catch(error => console.error('Error fetching todos:', error));
        },

        taskCounts() {
            this.state.total = this.allTodos.length;
            this.state.completed = this.allTodos.filter(task => task.is_completed).length;
        },

        addTask() {
            if (this.newTodo.trim() !== '') {
                fetch('/api/todos', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ description: this.newTodo }),
                })
                    .then(response => response.json())
                    .then(res => {
                        if (res.success) {
                            this.allTodos.push(res.data);
                            this.newTodo = '';
                            if (this.search.trim() === '') {
                                this.listTodo = this.allTodos;
                            } else {
                                this.fetchTodos();
                            }
                            this.taskCounts();
                            this.showNotification(res.message, 'success');
                        } else {
                            this.showNotification(res.message || 'Failed to add task', 'error');
                        }
                    })
                    .catch(error => console.error('Error adding task:', error));
            }
        },

        toggleComplete(id, completed) {
            fetch(`/api/todos/${id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    is_completed: !completed
                }),
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        this.allTodos = this.allTodos.map(task =>
                            task.id === id ? { ...task, is_completed: !task.is_completed } : task
                        );
                        if (this.search.trim() === '') {
                            this.listTodo = this.allTodos;
                        } else {
                            this.fetchTodos();
                        }
                        this.taskCounts();
                        this.showNotification(res.message, 'success');
                    } else {
                        this.showNotification(res.message || 'Failed to update task', 'error');
                    }
                })
                .catch(error => console.error('Error updating todo:', error));
        },

        removeTask(id) {
            fetch(`/api/todos/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ id: id }),
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        this.allTodos = this.allTodos.filter(task => task.id !== id);
                        if (this.search.trim() === '') {
                            this.listTodo = this.allTodos;
                        } else {
                            this.fetchTodos();
                        }
                        this.taskCounts();
                        this.showNotification(res.message, 'success');
                    } else {
                        this.showNotification(res.message || 'Failed to remove task', 'error');
                    }


                })
                .catch(error => console.error('Error adding task:', error));
        },

        filterTask() {
            if (this.state.filter === 'completed') {
                return this.listTodo.filter(task => task.is_completed);
            }
            if (this.state.filter === 'uncompleted') {
                return this.listTodo.filter(task => !task.is_completed);
            }
            return this.listTodo;
        },

        init() {
            this.fetchTodos();
        }
    }));
});

Alpine.start();

const form = document.getElementById('form');
const input = document.getElementById('input');
const todosUL = document.getElementById('todos');
const clearButton = document.getElementById('clear');

const todos = JSON.parse(localStorage.getItem('todos')) || [];

// Function to delete task from the database
function deleteTaskFromDatabase(username, taskId) {
    // You need to send an AJAX request to your server-side script
    // to delete the task from the user's table in the database.
    // Use fetch or XMLHttpRequest for the AJAX request.
    // Example using fetch:
    fetch(`DeleteTask.php?username=${username}&taskId=${taskId}`, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
}

function addTodo(todo) {
    let todoText = input.value;

    if (todo) {
        todoText = todo.text;
    }

    if (todoText) {
        const todoEl = document.createElement('li');
        if (todo && todo.completed) {
            todoEl.classList.add('completed');
        }

        todoEl.innerText = todoText;

        todoEl.addEventListener('click', () => {
            todoEl.classList.toggle('completed');
            updateLS();
        });

        todoEl.addEventListener('contextmenu', (e) => {
            e.preventDefault();

            // Remove the todo from UI
            todoEl.remove();

            // Update local storage
            updateLS();

            // Get the username from the user's authentication logic or storage
            const username = "user123"; // Change this with your authentication logic

            // Send an AJAX request to delete the task from the database
            const taskId = todo.id; // Assuming you have an ID for each task
            deleteTaskFromDatabase(username, taskId);
        });

        todosUL.appendChild(todoEl);

        input.value = '';

        updateLS();
    }
}

function updateLS() {
    const todosEl = document.querySelectorAll('li');
    const todos = [];

    todosEl.forEach((todoEl, index) => {
        todos.push({
            id: index, // Assign an ID for each task
            text: todoEl.innerText,
            completed: todoEl.classList.contains('completed'),
        });
    });

    localStorage.setItem('todos', JSON.stringify(todos));
}

form.addEventListener('submit', (e) => {
    e.preventDefault();
    addTodo();
});

clearButton.addEventListener('click', clearAllTodos);

function clearAllTodos() {
    todosUL.innerHTML = '';
    localStorage.removeItem('todos');
}

// Initial rendering of todos
todos.forEach(todo => addTodo(todo));

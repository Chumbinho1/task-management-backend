# Task Manager Backend

## Table of Contents

1. [Introduction](#introduction)
2. [Features](#features)
3. [API Routes](#api-routes)
4. [Testing](#testing)
5. [Contributing](#contributing)
6. [License](#license)

## Introduction

Welcome to the backend of the Task Manager application! This backend is built on Laravel version 11.29.0 and provides an API for managing tasks and user authentication. The application uses MySQL for the database and Laravel Sanctum for API authentication.

## Features

### User Authentication

- **Sign Up**: Register new users.
- **Sign In**: Authenticate users and provide a token for future requests.
- **Logout**: Invalidate user tokens and log out securely.

### Task Management

- **Create, Read, Update, Delete (CRUD)**: Full CRUD functionality for tasks.
- **Task Status**: Retrieve all task statuses.

## API Routes

### User Authentication

- **Sign Up**
    - `POST /auth/signup`
    - Registers a new user.

- **Sign In**
    - `POST /auth/signin`
    - Authenticates a user and provides a token.

- **Logout**
    - `POST /auth/logout`
    - Invalidates the user's token and logs out securely.

### Task Management

- **Retrieve All Tasks**
    - `GET /tasks`
    - Retrieves a list of all tasks.

- **Create Task**
    - `POST /tasks`
    - Adds a new task.

- **Retrieve Single Task**
    - `GET /tasks/{id}`
    - Retrieves the details of a specific task.

- **Update Task**
    - `PUT /tasks/{id}`
    - Updates the details of a specific task.

- **Delete Task**
    - `DELETE /tasks/{id}`
    - Deletes a specific task.

### Task Status

- **Retrieve All Task Statuses**
    - `GET /task-statuses`
    - Retrieves a list of all task statuses available.

## Testing

We use PHPUnit as the testing framework. To run the tests:

```bash
./vendor/bin/sail artisan test
```

Make sure you have the test environment configured in your `.env.testing` file.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch for your feature or fix.
3. Make your changes.
4. Submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

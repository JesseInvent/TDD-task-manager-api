# Task Manager API

### - Clone Repository 
```bash
$ git clone https://github.com/jesseinvent/TDD-task-manager-api 
```
### - Create a .env file
```bash 
$ touch .env 
```

### Copy all entries from .env.example to .env
```bash
$ cp .env.example .env
```
### - Set your prefer Database connection, username and password credentials in .env file
### - Create the following databases: taskApi and taskApi_test(for testing)
### - After successfully Database creation and setup, run all migration files
```bash
$ php artisan migrate 
```
### Startup the API
```bash
$ php artisan serve
```
## - Run all Test Suites
```bash
php artisan test
```


## - Startup Postman
## - Make request to Base URL
* GET http://127.0.0.1:8000

### Response: 
```javascript
[ Welcome to Task Manager API ]
```

## ROUTES

* **User Signup**
<br> <br>
Request:  `POST /api/auth/signup` <br>
Authentication: `none`<br>
Query Parameters: `none` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    name: John Doe,
    email: johndoe@gmail.com, 
    password: password,
    password_confirmation: password
}
```

Response Format: 

```
{
    "access_token": "eyJ0eXAiOiJKV1LCJhbGciOiJIUzI1NiJ9.yJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9zaWdudXAiLCJpYXQiOjE2MTY2OTA4",
    "token_type": "Bearer",
    "user": "John Doe",
    "expires_in": 3600
}
```
Success Status Code: 201 (created)

<br><br>

* **User Login**
<br> <br>
Request:  `POST /api/auth/login` <br>
Authentication: `none`<br>
Query Parameters: `none` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    email: johndoe@gmail.com, 
    password: password,
}
```

Response Format: 

```
{
    "access_token": "eyJ0eXAiOiJKV1LCJhbGciOiJIUzI1NiJ9.yJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9zaWdudXAiLCJpYXQiOjE2MTY2OTA4",
    "token_type": "Bearer",
    "user": "John Doe",
    "expires_in": 3600
}
```
Success Status Code: 200 (OK)

<br><br>

* **Creating a Task**
<br> <br>
Request:  `POST /api/tasks` <br>
Authentication: `none`<br>
Query Parameters: `none` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    body: Task One, 
}
```

Response Format: 

```
{
    "id": 1,
    "body": "Task One",
    "completed": false,
    "completed_at": "Task not completed",
    "created_at": "1 second ago"
}
```
Success Status Code: 201 (Created)


<br><br>

* **Get Task**
<br> <br>
Request:  `GET /api/tasks/:id` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `id: task id` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    body: Task One, 
}
```

Response Format: 

```
{
    "id": 7,
    "body": "Optio voluptate autem voluptas.",
    "completed": false,
    "completed_at": "Task not completed",
    "created_at": "8 minutes ago"
}
```
Success Status Code: 200 (OK)


<br><br>

* **Get User Tasks**
<br> <br>
Request:  `GET /api/tasks` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `none` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    body: Task One, 
}
```

Response Format: 

```
[    {
        "id": 1,
        "body": "Task One",
        "completed": false,
        "completed_at": "Task not completed",
        "created_at": "6 min ago"
    },
    {
        "id": 2,
        "body": "Task Two",
        "completed": false,
        "completed_at": "Task not completed",
        "created_at": "8 mins ago"
    },
]
```
Success Status Code: 200 (OK)


<br><br>

* **Update a task**
<br> <br>
Request:  `PATCH /api/tasks/:id` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `id: task id` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: 

```
{ 
    body: Updated Task, 
}
```

Response Format: 

```
{
    "id": 1,
    "body": "Task One",
    "completed": false,
    "completed_at": "Task not completed",
    "created_at": "1 second ago"
}
```
Success Status Code: 202 (Accepted)


<br><br>

* **Mark a task as completed**
<br><br>
Request:  `POST /api/tasks/:id/completed` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `id: task id` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: `none`

Response Format: 

```
{
    "id": 4,
    "body": "Updated Task",
    "completed": true,
    "completed_at": "1 second ago",
    "created_at": "1 day ago"
}
```
Success Status Code: 201 (Created)


<br><br>

* **Mark a completed task as uncompleted**
<br><br>
Request:  `DELETE /api/tasks/:id/completed` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `id: completed task id` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: `none`

Response Format: `none`

Success Status Code: 204 (No content)


<br><br>

* **Delete a task**
<br><br>
Request:  `DELETE /api/tasks/:id` <br>
Authentication: `Bearer Token`<br>
Query Parameters: `id: completed task id` <br>
```
Headers: 

Accept: application/json
Content-type: application/json
``` 

Body Format: `none`

Response Format: `none`
```
Success Status Code: 204 (No content)



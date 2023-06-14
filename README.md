# To Do List Api


[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

## 🚨 important!
It is necessary to have Docker and Docker Compose to run the project.

## 🛠 Setup
Just run the following command to get up and running:
```sh
./vendor/bin/sail up
```
It will bring up a container with PHP and Laravel, Composer will install the libs, and then the server will be ready

## 💻 Usage
First, you'll need to create a user by making a POST request to /api/auth/register, following the JSON structure below. 

```sh
{
	"nome": "example name",
	"email": "example@mail.com", 
	"password": "123456"
}
```
An authentication token will be generated, which should be sent in the requests as "bearer token".

"If you already have a user created, simply send the email and password to /api/auth/register, following the JSON structure below."

```sh
{
    "email": "example@mail.com", 
	"password": "123456"
}
```
To create a task, just make a POST request to /api/tasks, following the JSON structure below.
```sh
{
    "title": "example task",
    "description": "This is a example task",
    "completed": 0,
    "attachment":"","type":"file","enabled":true,"value": ["/path/to/file"]
}
```

To update a task, just make a PUT request to /api/tasks/{id}, following the JSON structure below.
```sh
{
    "title": "example task",
    "description": "This is a example task",
    "completed": 0,
    "attachment":"","type":"file","enabled":true,"value": ["/path/to/file"]
}
```

To list all tasks, just make a GET request to /api/tasks.

To list a specific task, just make a GET request to /api/tasks/{id}.

To delete a task, just make a DELETE request to /api/tasks/{id}.

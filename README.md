# Task Management System (Laravel + JWT Auth)

This is a simple task management system built with **Laravel** and **JWT Authentication**. It allows users to register, log in, manage tasks, and log out securely.

## 🚀 Features
- User Authentication with **JWT**
- Task CRUD (Create, Read, Update, Delete)
- Task filtering by status (`pending`, `completed`)
- Role-based access control (Guest vs Authenticated users)
- Secure logout with token invalidation

## 🛠 Installation Guide

1. **Clone the Repository**  
```sh
git clone https://github.com/AINS11/Task-Management-System.git
cd Task-Management-System
```

2. **Install Dependencies**  
```sh
composer install
```

3. **Configure Environment**  
```sh
cp .env.example .env
```
Update `.env` file with **database** and **JWT secret**:
```env
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
JWT_SECRET=your_secret_key
```

4. **Generate JWT Secret Key**  
```sh
php artisan jwt:secret
```

5. **Run Migrations**  
```sh
php artisan migrate
```
6. **Clear and cache configuration**
```sh
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

7. **Start the Server**  
```sh
php artisan serve
```

## 🔑 Authentication Routes (API)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | `/register` | Register a new user |
| POST   | `/login` | Login and get JWT token |
| POST   | `/logout` | Logout and invalidate token |

## 🎯 Task Management Routes (API)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/tasks` | Get all tasks (authenticated users only) |
| POST   | `/tasks` | Create a new task |
| PUT    | `/tasks/{id}` | Update a task |
| DELETE | `/tasks/{id}` | Delete a task |
| GET    | `/tasksfilter/{status}` | Filter tasks by `all`,`pending` and `completed` |

## 🔒 Access Control

| User Type  | Can Access |
|------------|-----------|
| Guest | Only `/login` and `/register` |
| Authenticated | Task management, logout |



## 🤝 Contributing
1. Fork the repo  
2. Create a new branch (`git checkout -b feature-branch`)  
3. Commit changes (`git commit -m 'Add new feature'`)  
4. Push to branch (`git push origin feature-branch`)  
5. Create a Pull Request  



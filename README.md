
# Simple REST API - Todo List Management

This project is a simple RESTful API built with **Laravel 12**, focused on user authentication and checklist management. It provides features such as user registration and login, along with the ability to create and manage checklists and their items.

## Features

### 🔐 Authentication
- ✅ **User Registration**
- ✅ **User Login** (Token-based using Laravel Sanctum)

### ✅ Checklist
- 📝 **Create Checklist**
- 📃 **List All Checklists**
- ❌ **Delete Checklist**

### 📋 Checklist Items
- 📄 **List Items in a Checklist**
- 🔍 **Show Item Details**
- ✏️ **Rename Item**
- 🔄 **Update Item Status**
- 🗑️ **Delete Item**

## Requirements

- PHP >= 8.3
- Composer
- Laravel 12.x or higher
- MySQL or any other database supported by Laravel

## Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/sofronz/simple-todo-api.git
```

### 2. Install Dependencies

Navigate to the project directory and run:

```bash
cd simple-todo-api
composer install
```

### 3. Set Up Environment File

Copy the example environment file and edit the database settings:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database settings, like:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 5. Run Migrations

Run the migrations to set up your database.

```bash
php artisan migrate
```

### 6. Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

## API Documentation

For detailed API documentation, please refer to one of the following:

- **Public Docs (Postman):**  
  [API Documentation](https://documenter.getpostman.com/view/10125362/2sB2cYcfnc)

- **Swagger Docs (Local):**  
  Clone this project and run it locally, then access:  
  `http://localhost:8000/api/documentation`


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
# 📝 Laravel 12 Blog Application

A clean blog management system built with **Laravel 12**, supporting multiple roles like **Superadmin**, **Admin**, and **Author**. No packages like Spatie, Policies, or Gates are used — only built-in Laravel features.

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/Tejendra14/laravel-blogs.git
cd laravel-blog

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example `.env` file:

```bash
cp .env.example .env
```

Update your `.env` to use MySQL:

```env
# Comment out if sqlite exists
# DB_CONNECTION=sqlite

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogs
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Configure Mail (using Mailtrap)

Create an account at [https://mailtrap.io](https://mailtrap.io) and update the mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@blog.com
MAIL_FROM_NAME="Laravel Blog"
```

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Migrate and Seed the Database

```bash
php artisan migrate --seed
```

This will:

* Create all necessary tables
* Seed:

  * Roles (`superadmin`, `admin`, `author`)
  * Default **superadmin** user

```
Email: superadmin@gmail.com
Password: password
```

---

## 🔐 Login URLs

| Role       | Login URL                                                                        |
| ---------- | -------------------------------------------------------------------------------- |
| Superadmin | [http://127.0.0.1:8000/superadmin/login](http://127.0.0.1:8000/superadmin/login) |
| Admin      | [http://127.0.0.1:8000/auth/login](http://127.0.0.1:8000/auth/login)             |
| Author     | [http://127.0.0.1:8000/auth/login](http://127.0.0.1:8000/auth/login)             |

> Use the Superadmin panel to create new users and assign roles.

---

## ✨ Features

* Create/manage **categories**, **tags**, and **posts**
* Each post is linked to a category and can have multiple tags
* WYSIWYG editor support (CKEditor integrated)
* **Authors** can create & submit posts
* **Admins** can approve/reject posts
* Email notification sent upon post approval
* Roles: Superadmin, Admin, Author
* Uses `SoftDeletes` for posts

---

## 📑 Project Structure

* **Admin Dashboard**: `/admin`
* **Superadmin Panel**: `/superadmin`
* No external role/permission package
* All access control handled using middleware and custom logic

---

## 🧪 Running the App

```bash
php artisan serve

Visit:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

Use **simple present tense**:

✅ `Add post approval logic`
✅ `Fix create post form layout`
✅ `Create seeder for tags`

## 🛠 Author Setup Task

After logging in as superadmin:

1. Create one user with role `admin`
2. Create another user with role `author`
3. Use these accounts to test post submission and approval flows

## 📃 License

Open source under the [MIT license](LICENSE).

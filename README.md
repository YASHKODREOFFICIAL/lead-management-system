<p align="center">
    <a href="#" target="_blank">
        <img src="https://img.icons8.com/?size=512&id=cZbayYzHnraW&format=png" width="200" alt="Lead Management Logo">
    </a>
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Status-Active-brightgreen" alt="Project Status"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/API-Sanctum-blue" alt="API"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-yellow" alt="License"></a>
</p>

<h2 align="center">Lead Management System (Laravel + Sanctum API)</h2>

---

## 📌 **About the Project**

The **Lead Management System** is a CRM-style application built using **Laravel 12** with:

- 🔐 **Role-Based Access Control** (Admin + Counsellor)
- 👨‍💼 **Admin**: Full CRUD, assign leads, delete leads  
- 👨‍🏫 **Counsellor**: Can view/add/update only their assigned leads  
- 📝 Advanced **filters + search** (name/email/phone)  
- 🕒 **Lead history tracking** (status changes + assignment log)  
- 🔑 **API support** using Laravel Sanctum  
- 🗄 **SQLite database** for portability  

---

# 🏗 **Tech Stack**

| Component | Technology |
|----------|------------|
| Backend | Laravel 12 |
| Authentication | Laravel Sanctum |
| Roles & Permissions | Spatie Laravel Permission |
| Database | SQLite |
| UI | Blade + TailwindCSS |
| API Testing | Thunder Client / Postman |

---

# 🚀 **Project Setup Instructions**

## 1️⃣ Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/lead-management-system.git
cd lead-management-system

2️⃣ Install Composer Dependencies

composer install

3️⃣ Create Environment File

cp .env.example .env

4️⃣ Generate Application Key

php artisan key:generate


5️⃣ Configure SQLite Database

Create SQLite file:
touch database/database.sqlite

Update .env:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite


6️⃣ Run Migrations

php artisan migrate

7️⃣ Install Spatie Permission Package

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

8️⃣ Install Laravel Sanctum

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

9️⃣ Install Laravel Sanctum

composer require laravel/sanctum

🔟 Publish Sanctum

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

1️⃣1️⃣ Start Laravel Server

php artisan serve

🔑 Generate API Token

Generate Token in Tinker
php artisan tinker

Then:
$user = App\Models\User::find(1);
$token = $user->createToken('API Token')->plainTextToken;
$token;


📡 API Request (Thunder Client)

Endpoint
POST http://127.0.0.1:8000/api/leads/create

Headers
Authorization: Bearer YOUR_TOKEN
Accept: application/json

JSON Body

{
  "name": "Yash Kodre",
  "email": "yash@example.com",
  "phone": "9552973186",
  "source": "Google",
  "status": "New"
}



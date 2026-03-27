# eShop (Laravel) - Project Overview

This project is an e-commerce application built with **Laravel**. It supports two user types: **clients (customers)** and **admins**. The project includes cart & wishlist features, product browsing, order placement, and admin dashboard management.

---

##  Key Features
- **Client/User Side**
  - Product listing & details
  - Cart: add/update/remove/clear
  - Wishlist (requires login)
  - Checkout + order placement
  - Order history & status

- **Admin Side**
  - Admin login & dashboard
  - Manage products, categories, orders, users, queries

---

##  Core Structure
- **Routes**: `routes/web.php`
  - Client routes (shop + cart + orders + wishlist)
  - Admin routes (prefixed with `/admin`)
- **Controllers**: `app/Http/Controllers` (split into `Auth/Client`, `Auth/Admin`, and general controllers)
- **Models**: `app/Models/Auth/Client/User.php` and `app/Models/Auth/Admin/AdminUser.php`
- **Middleware**: `app/Http/Middleware/IsClient.php`, `app/Http/Middleware/IsAdmin.php`
- **Views**: `resources/views` (split into client and admin directories)

---

##  Authentication
- Uses Laravel session auth.
- Admin login uses an **admin guard** and admin routes are protected by **`auth:admin` + `admin` middleware**.
- Client login uses the default **web guard**.

---

##  Cart & Wishlist
- Cart actions are handled via endpoints like:
  - `POST /cart/add`
  - `POST /cart/update`
  - `POST /cart/remove`
  - `GET /cart`
- Wishlist is protected by auth and has endpoints like:
  - `GET /wishlist`
  - `POST /wishlist/add`
  - `POST /wishlist/remove`

---

##  Notes
- Admin and client users may share the same database table; separation is managed via `role` column and guard configuration.
- The project uses **Vite** for frontend asset building.

---

##  Useful Commands
- `php artisan route:list` — See all routes
- `php artisan migrate` — Run database migrations
- `php artisan db:seed` — Seed initial data
- `npm run dev` — Start frontend dev server
- `npm run build` — Build assets for production

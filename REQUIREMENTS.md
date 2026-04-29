# Project Requirements

##  System Requirements
- **PHP**: 8.1+ (Laravel 10+ recommended)
- **Composer**: for dependencies
- **MySQL / MariaDB** (or another supported SQL database)
- **Node.js + npm/yarn**: for frontend assets (Vite)



##  Environment Setup
- Copy `.env.example` to `.env`
- Set database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)


## for displaying images properly  
go to https://drive.google.com/drive/folders/1rU87ygFDLEqWkkIU4Vc8mfr6x87MCs-_?usp=drive_link
and downlaod uplaods folder and copy it then paste
inside public storage folder for images 


##  Installation (first time)
```bash
composer install
npm install
npm run build
php artisan migrate --seed
```

##  Running the App (local)
```bash
php artisan serve
npm run dev
```


##  Authentication / Guards
This project uses **two authentication guards**:
- `web` (default) for client users (shopper)
- `admin` for admin dashboard users

Each guard uses a separate provider (based on separate model classes), but both can use the same `users` table.






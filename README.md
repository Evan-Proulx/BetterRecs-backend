# Better Recs Backend
This is the Laravel backend api for the [Better Recs project](https://github.com/Evan-Proulx/Better-Recs). It handles user authentication and storing user albums.

## Requirements
- **PHP** >= 8.2
- **Composer** 
- **Node.js**: ^18.x (or a version compatible with Vite)

## Installation and Setup
1. Clone the repo: `git clone https://github.com/Evan-Proulx/Better-Recs-backend.git`
2. cd BetterRecs-backend
3. Run `composer install`
4. Navigate to the .env file and ensure it has this code block:
```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=better_recs_backend
   DB_USERNAME=root
   DB_PASSWORD=
```
5. Run database migrations: `php artisan migrate`
6. Run the application: `php artisan serve`

## API Documentation

### Endpoints:

- POST /api/auth: Authenticates a user. Requires **Email** and **Password**
- POST /api/reg: Registers a new user. Requires **Name**, **Email**, **Password** and **Password Confirmation**
- GET /api/albums: Gets a users saved albums. Requires a **Bearer Token**
- DEL /api/albums/{21}: Deletes a user album. Requires a **Bearer Token**
- POST /api/albums?spotify_id=&title=&artist=&release_date=&genre=&image_url=: Creates a new album. Requires album information

### Authentication 
This API uses token-based authentication. When a user is logged in they are given a bearer token. All other requests are made using this token.

## Author

- [@Evan-Proulx](https://www.github.com/Evan-Proulx)

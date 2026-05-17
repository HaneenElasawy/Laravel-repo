# ITI Open Source Track: Laravel Course - Final Project

This repository contains the final project for the Laravel course in the ITI Open Source track. It is a full-featured web application and API demonstrating modern backend development practices using the Laravel framework.

## Project Roadmap (Labs 1-5 Summary)

* **Lab 1: Laravel Basics & Blade Templating**
  * Initialized the Laravel application.
  * Designed the core layout using Blade templates.
  * Implemented basic routing and static views.

* **Lab 2: Database Migration, Models & Eloquent ORM**
  * Created database schema using migrations.
  * Defined Eloquent Models (`User`, `Post`) with their corresponding relationships.
  * Utilized Laravel Tinker to insert test data.

* **Lab 3: Controllers & Request Validation**
  * Created controllers to handle CRUD operations.
  * Enforced robust form validation for incoming requests.
  * Displayed validation errors and handled old input data in the UI.

* **Lab 4: File Uploads & Authentication**
  * Handled secure image uploads to the public storage disk.
  * Implemented standard Laravel UI/Breeze authentication.
  * Guarded specific routes to ensure only authenticated users can create, update, or delete records.
  * Bound model access using Policies/Gates to ensure users only modify their own resources.

* **Lab 5: RESTful APIs & Laravel Sanctum**
  * Designed separate route files to keep API and Web endpoints clean.
  * Built API Controllers (`AuthController`, `PostController`) for stateless operations.
  * Formatted API responses cleanly using API Resources (`PostResource`).
  * Secured API routes via Laravel Sanctum authentication.

## Local Setup & Installation

To run this project locally, follow these steps:

1. **Clone the repository & install dependencies:**
   ```bash
   git clone <repository_url>
   cd <repository_folder>
   composer install
   ```

2. **Environment Configuration:**
   * Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   * Update the database credentials in the `.env` file (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

3. **Generate Application Key & Link Storage:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

4. **Database Migration & Seeding:**
   * Run the migrations to generate tables:
     ```bash
     php artisan migrate
     ```
   * Run seeders to populate the database with initial users and posts:
     ```bash
     php artisan db:seed
     ```

5. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

## Testing the API with Postman

### 1. Register a New User
* **Endpoint:** `POST /api/register`
* **Body (Form-Data or JSON):**
  * `name`: John Doe
  * `email`: john@example.com
  * `password`: password123
  * `password_confirmation`: password123
* **Expected Output:** Returns the user object and the generated `token`.

### 2. Login
* **Endpoint:** `POST /api/login`
* **Body (JSON):**
  * `email`: john@example.com
  * `password`: password123
* **Expected Output:** Returns the generated `token` for further authenticated requests.

### 3. Access Protected Routes
To access the protected API routes (e.g., creating or updating posts), use the token acquired from the login response:
* Open the **Authorization** tab in Postman.
* Select **Bearer Token**.
* Paste the copied token.
* **Endpoint:** `GET /api/posts` (or POST, PUT, DELETE)

Enjoy exploring the application!

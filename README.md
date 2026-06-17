# Casa Paraiso Capstone Agile Board / Web-Based Spa Service Management and Appointment Booking System

## Short Project Description
A Laravel-based web application for Casa Paraiso – Body and Wellness Spa. This system provides a comprehensive appointment booking, service management, and business intelligence platform to streamline operations for the manager, therapists, and customers.

## Tech Stack
- **Backend:** Laravel 11/12
- **Frontend:** Livewire (Volt) + Tailwind CSS + Alpine.js
- **Database:** MySQL
- **Environment:** XAMPP (Local Development)

## Current Completed Setup
- Initialized base Laravel project.
- Configured Livewire/Tailwind CSS using Laravel Breeze.
- Implemented Role-Based Access Control (RBAC).
- Set up automated post-login redirection based on user roles.
- Scaffolded Manager, Therapist, and Customer dashboards.

## User Roles
1. **Manager**: Full access to manage services, therapists, bookings, transactions, and view analytics/reports.
2. **Therapist**: Access to view their personal schedule, track completed services, and check estimated commissions.
3. **Customer**: Access to book appointments, view upcoming bookings, and see available promotions.

## Local Setup Commands
1. **Create the database** in phpMyAdmin named `casa_paraiso_db`.
2. **Clone the repository** (if not already done).
3. **Install dependencies**: `composer install` and `npm install`.
4. **Copy `.env.example` to `.env`** and verify database credentials (`mysql`, `127.0.0.1`, `casa_paraiso_db`).
5. **Generate app key**: `php artisan key:generate`
6. **Run migrations and seeders**: `php artisan migrate:fresh --seed`
7. **Build assets**: `npm run build` (or `npm run dev` for hot-reloading)
8. **Start the server**: `php artisan serve`

## Seeded Test Accounts
All seeded accounts share the same password: `password`
- **Manager**: `manager@casaparaiso.test`
- **Therapist**: `therapist@casaparaiso.test`
- **Customer**: `customer@casaparaiso.test`

## Git Workflow
- Default branch is `main`.
- Feature branches are recommended for isolated development.
- Always commit clean, working code.
- Ensure sensitive files (`.env`, database backups) are excluded via `.gitignore`.

## Agile Progress Tracking
This project follows a 6-week MVP Agile workflow.
For detailed rules, logs, and backlog, see the `docs/agile/` directory.
- `SPRINT_RULES.md`
- `MVP_BACKLOG.md`
- `SPRINT_LOG.md`

## Definition of Done
A feature is considered "Done" when:
- The code works as expected.
- It has been tested manually (or automatically).
- It is committed and pushed to GitHub.
- Proof of functionality (screenshot or demo note) is documented.

## Current Sprint Status
Currently in **Sprint 1: Foundation and Dashboard Setup**.

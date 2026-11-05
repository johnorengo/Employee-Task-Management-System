# Employee Task Management System

This repository contains the original campus project. It runs the existing PHP application in Docker with PostgreSQL and a local Mailpit inbox.

## Local setup

1. Copy `.env.example` to `.env` and set a local database password.
2. Run `docker compose up -d --build`.
3. Open [ETMS](http://localhost:3001). Assignment emails are captured in [Mailpit](http://localhost:8026).

For a fresh database, create your first administrator from the project directory:

```powershell
docker compose exec app php /usr/local/bin/create-admin.php admin "Campus Administrator" admin@example.test
```

The command prints a generated password. Use the username and password on the existing login page. Employee creation, temporary passwords, task statuses and attendance continue through the original screens.

The PostgreSQL volume is initialized from `docker/schema.sql`. The Compose project uses its own volume, separate from the previous ETMS project. `docker compose stop` stops the services while retaining the database. Existing MySQL rows require a separate export and import.

The Laravel and Next.js ports are subsequent work. The original workflow in this repository is the reference for both.

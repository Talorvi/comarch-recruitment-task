# Comarch Recruitment Task

## Description

This PHP script enables the sending of email messages to users grouped by specific categories. It uses a MySQL database
to manage user data and category assignments.

## Features

- User Management: Users are stored in a database with support for multiple category assignments.
- Category-based Email Targeting: Allows sending emails to users based on their category.
- Dynamic Email Content: Supports the inclusion of user-specific variables (e.g., first name, last name) in the email
  content.
- Flexible Message Input: Email messages can be hardcoded or input via a user form.
- Tech Stack
    - **PHP 8.2**: Core scripting language.
    - **MySQL 8.0**: Database for storing user and category data.
    - **Docker**: Used to containerize the application.
    - **TailwindCSS**: Used for styling any HTML forms.

## Directory Structure

- `/database`: SQL scripts for creating and populating database tables.
- `/src`: PHP classes for the application logic, split into models, repositories, and services.
- `/logs`: Storage for log files.
- `/tests`: PHPUnit tests for the application components.

## Application Structure

- `Interfaces` - Contains interface definitions that ensure consistent method signatures across different classes.
- `Models` - Represents the data structures used within the application.
- `Repositories` - Contains classes responsible for handling data retrieval and manipulation from the database.
- `Scripts` - Scripts that can be run from the command line or through a browser to perform specific tasks.
- `Services` - Contains business logic and service-layer functionalities.
    - `DatabaseService.php`: Singleton class that manages database connections.
    - `EmailSenderService.php`: Service responsible for sending emails based on user categories.

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Talorvi/comarch-recruitment-task.git
```

2. Move to the working directory:

```bash
cd comarch-recruitment-task
```

3. Run docker-compose:

```bash
docker-compose up --build
```

4. Initialize and seed the database, enter this in browser to run the script:

```
http://localhost:8080/scripts/initialize_database.php
```

5. The form is available on:

```
http://localhost:8080/
```

The emails sent will be logged in `/comarch-recruitment-task/project/logs/email_log.txt`.
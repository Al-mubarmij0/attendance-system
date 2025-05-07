# Attendance System Using Barcode

This repository contains the source code and documentation for the Attendance System Using Barcode featuring Al-Qalam University Katsina (AUK).

## Project Overview
This project aims to create an efficient and automated attendance system using barcode technology. The system will allow faculty members to track student attendance through barcode scanning, making the process faster, more accurate, and more secure. The system integrates with the current AUK website, enhancing usability, design, and functionality.

Key features include barcode generation for students, real-time attendance tracking, and data analytics.

## Features
- Barcode Generation: Creates unique barcodes for each student, which can be scanned to mark attendance.
- Student Management: Enables officials to manage student profiles and attendance data.
- Course Management: Facilitates scheduling, materials, and attendance tracking for courses.
- Attendance Tracking: Automatically marks student attendance when their barcode is scanned.
- Reports & Analytics: Generates detailed attendance reports for faculty and students.
- Admin Management: Allows admins to manage user roles, settings, and system configurations.


## Technologies

The project leverages the following technologies:

-   **HTML5**: A markup language for structuring content on the web.
-   **CSS3**: Style sheet language for describing the presentation of web pages.
-   **JavaScript**: Programming language for creating interactive and dynamic web content.
-   **Tailwind CSS**: Utility-first CSS framework for building custom designs.
-   **PHP**: Server-side scripting language for dynamic web content.
-   **Laravel**: PHP framework for building robust web applications.
-   **MySQL**: Relational database management system for data storage and retrieval.
-   **Barcode Scanner Integration**: Integration with barcode scanners for real-time attendance marking.

## Design Guidelines

-   **Color Scheme**: Use the 60/30/10 color rule for the design. This rule suggests that 60% of the color scheme should be a dominant color, 30% should be a secondary color, and 10% should be an accent color to create visual interest and balance.
-   **Database Column Naming**: All database column names must comply with the lowercase and underscore format. For example, use first_name instead of FirstName or firstName.
-   **Database**: The project must use MySQL as the database system.

## Getting Started

To get started with the project, follow these steps:

### Prerequisites

Ensure you have the following installed on your system:

-   [Git](https://git-scm.com/)
-   [PHP (>= 7.4)](https://www.php.net/downloads)
-   [Composer](https://getcomposer.org/download/)
-   [Node.js and npm](https://nodejs.org/en/download/)
-   [MySQL](https://dev.mysql.com/downloads/)
-   [Laravel](https://laravel.com/docs/8.x/installation)
-   [Tailwind CSS](https://tailwindcss.com/docs/installation)
-   [Visual Studio Code](https://code.visualstudio.com/)
-   [GitHub Desktop](https://desktop.github.com/)

-   **PDO (PHP Data Object)** is mandatory for this project, no use of Procedural PHP.

### Installation

1. **Clone the Repository**

    Clone the repository to your local machine using the following command:

    
```sh
    git clone https://github.com/Al-mubarmij0/attendance-system.git
```

2. **Navigate into the Project Directory**

    Navigate into the project directory:

    
```sh
    cd attendance-system
```

3. **Install PHP Dependencies**

    Use Composer to install all PHP dependencies required by the project:

    
```sh
    composer install
```

4. **Install Node.js Dependencies**

    Use npm to install all Node.js dependencies required for frontend assets:

    
```sh
    npm install
```

5. **Create a Copy of the Environment File**

    Copy the .env.example file to .env:

    
```sh
    cp .env.example .env
```

6. **Generate an Application Key**

    Generate the application key for the Laravel application:

    
```sh
    php artisan key:generate
```

7. **Set Up the Database**

    - Open the .env file and update the database configuration to match your local setup:

        
```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_username
        DB_PASSWORD=your_password
```

- Run the database migrations to set up the necessary tables:

        
```sh
        php artisan migrate
```

8. **Serve the Application**

    Start the development server:

    
```sh
    php artisan serve
```

9. **Compile Assets**

    Compile the frontend assets using Laravel Mix:

    
```sh
    npm run dev
```

For production:

    
```sh
    npm run prod
```

### Deployment

For deployment to a production environment, follow these additional steps:

1. **Optimize the Application**

    Optimize the Laravel application for production:

    
```sh
    php artisan optimize
```

2. **Set Up a Web Server**

    Ensure you have a web server like Apache or Nginx configured to serve the Laravel application.

3. **Run Database Migrations**

    Run migrations on the production server to ensure the database is up to date:

    
```sh
    php artisan migrate --force
```

4. **Compile Assets for Production**

    Ensure assets are compiled for production:

    
```sh
    npm run prod
```

### OS Compatibility Guidelines

**Supported Operating Systems:**

-   Windows 10/11
-   macOS Big Sur or later
-   Ubuntu 20.04 LTS or later

**Special Instructions:**

-   Windows users: Ensure you have WSL2 set up for a smoother development experience.
-   macOS users: Use Homebrew to manage dependencies efficiently.
-   Linux users: Make sure all required packages are installed via apt or other package managers.

### Recommended Text Editors

**VS Code:**

-   Install the following extensions:
    -   PHP Intelephense
    -   Laravel Snippets
    -   GitLens

**Sublime Text:**

-   Ensure Package Control is installed.
-   Recommended Packages:
    -   SublimeLinter
    -   GitGutter
    -   Laravel Blade Highlighter

**PHPStorm:**

-   Take advantage of the built-in support for PHP and Laravel.
-   Recommended Plugins:
    -   Laravel Idea
    -   PHP Annotations
    -   Git ToolBox

### Commit Message Guidelines

**Use of Blackbox:**

-   The use of [Blackbox](https://blackbox.com) is required for generating faster and standardized commit messages.
-   This will ensure consistency and save time during the commit process.

  ##Authors 
  - mohammedmubaraksani@gmail.com

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

    Copy the `.env.example` file to `.env`:

    ```sh
    cp .env.example .env
    ```

6. **Generate an Application Key**

    Generate the application key for the Laravel application:

    ```sh
    php artisan key:generate
    ```

7. **Set Up the Database**

    - Open the `.env` file and update the database configuration to match your local setup:

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


# Laravel_Test


This is a Laravel project that includes a user dashboard for task management. The application is built using Laravel and Vite for asset management.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 8.0
- Composer
- Node.js and NPM
- MySQL or another compatible database

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/YourUsername/Laravel_Test.git
   cd Laravel_Test
   cd Mytest
   ```

2. **Install Composer Dependencies**:
   Run the following command to install the Laravel dependencies:
   ```bash
   composer install
   ```

3. **Install NPM Dependencies**:
   After installing Composer dependencies, install the Node.js packages:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   Copy the example environment file and set up your environment variables:
   ```bash
   cp .env.example .env
   ```
   Edit the `.env` file to configure your database and other settings.

5. **Generate Application Key**:
   Generate the application encryption key:
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**:
   Set up the database by running the migrations:
   ```bash
   php artisan migrate
   ```

7. **Build Assets**:
   Compile your assets using Vite:
   ```bash
   npm run build
   ```

   For development mode, you can use:
   ```bash
   npm run dev
   ```

## Running the Application

After completing the above steps, you can run the Laravel development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.



This README file will help anyone who clones your project understand how to set it up and get started. If you have any specific features or instructions you'd like to include, feel free to modify it further!

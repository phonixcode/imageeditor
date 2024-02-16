# Image Editor Project Setup Guide

This guide will walk you through the process of cloning and setting up a Image Editor project on your local development environment.

Demo

- Open a web browser and navigate to <https://imageeditor.up.railway.app>.
- Open a web browser and navigate to <https://imageeditor.up.railway.app/login> to have access to the `CLIPDROP_API_KEY` page.
  - `email: admin@admin.com`
  - `password: admin12345`

## Prerequisites

Before you begin, make sure you have the following prerequisites installed on your computer:

- PHP
- Composer
- Git

## Step 1: Clone the Image Editor Project

1. Open your terminal/command prompt.
2. Navigate to the directory where you want to create your Laravel project.

    ```shell
    cd /path/to/your/directory

3. Run the following command to clone a image editor project from a Git repository (replace `project-name` with your desired project name):  

   ```shell
    git clone https://github.com/phonixcode/imageeditor.git

## Step 2: Install Dependencies

1. Change your working directory to the project folder:

    ```shell
    cd project-name

2. Run Composer to install Laravel's dependencies:

    ```shell
    composer install

## Step 3: Configure Environment Variables

1. Duplicate the `.env.example` file and rename it to `.env`:

    ```shell
    cp .env.example .env`

2. Open the `.env` file and enter your `CLIPDROP_API_KEY`.

## Step 4: Generate an Application Key

Run the following command to generate a unique application key:

     php artisan key:generate

## Step 5: Database

1. Create a new database 
2. Open the `.env` file and enter your `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

Run the following command to generate the databse tables and seed data:

     php artisan migrate:fresh --seed

## Step 6: Start the Development Server

    php artisan serve

This will start the server at <http://localhost:8000> by default.

## Step 7: Access Your Image Editor Application

- Open a web browser and navigate to <http://localhost:8000> (or the URL shown in your terminal).
- You should see the default Image Editor page, indicating that your project is set up successfully.
- Open a web browser and navigate to <http://localhost:8000/login> to have access to the `CLIPDROP_API_KEY` page.
     - `email: admin@admin.com`
     - `password: admin12345`

## Additional Configuration (Optional)

You can configure additional settings, such as setting up a virtual host, configuring your web server (e.g., Apache or Nginx), or adding more Laravel packages, as needed for your project.

That's it! You've successfully cloned and set up a Image Editor project on your local development environment. You can now start building and working Image Editor application.

### Troubleshooting

If you encounter any issues during the setup process, you can refer to the <a href="https://laravel.com/docs/">Laravel documentation</a> for more information and troubleshooting tips.

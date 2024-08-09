<h1 align="center">Batik Supply Chain Management App. </h1>

<p align="center">
The Batik Supply Chain Management App is designed to streamline and optimize the process of managing the batik production supply chain. From sourcing raw materials to tracking finished goods, this app helps batik producers, suppliers, and distributors maintain a clear and efficient workflow.
</p>

<p align="center">
    <img src="https://media1.tenor.com/m/phXC2y9QVa0AAAAd/bocchi-the-rock-kita-ikuyo.gif" alt="Wife" width="400">
</p>

### Installation

To set up the project locally, follow these steps:

1. **Clone the repository**:
    ```sh
    git clone https://github.com/DwiKrisnandi1905/SCM_Batik.git
    cd SCM_Batik
    ```

2. **Install Dependencies**:
    ```sh
    composer install
    ```

3. **Set Up Environment Variables**:
    ```sh
    mv .env.example .env
    ```
    > Edit the `.env` file to include your specific environment variables, such as database connection details.

4. **Run Migrations**:
    ```sh
    php artisan migrate
    ```

5. **Run Seeders**:
    ```sh
    php artisan db:seed
    ```
    > This will populate the database with initial data for testing and development purposes.

6. **Start the Server**:
    ```sh
    php artisan serve
    ```
    > The server will start on the default port 8000. You can now access your web application by navigating to [http://localhost:8000](http://localhost:8000) in your web browser.
### Production Mode

To run the project in production mode, follow these additional steps:

1. **Generate Application Key**:
    ```sh
    php artisan key:generate --force
    ```
    > This will generate a unique application key required for secure sessions and other encrypted data.

2. **Reinstall Composer Dependencies Without Development Packages**:
    ```sh
    composer install --no-dev --optimize-autoloader --no-interaction
    ```
    > This will install only the necessary production dependencies, exclude development packages, and optimize the autoloader for better performance.

3. **Optimize Autoloader**:
    ```sh
    composer dump-autoload --optimize
    ```
    > This will optimize the autoloader for better performance in production.

4. **Clear Cache**:
    ```sh
    php artisan cache:clear
    ```
    > This will clear the application cache.

5. **Enable Maintenance Mode**:
    ```sh
    php artisan down
    ```
    > This will put the application into maintenance mode.

6. **Configure Web Server**:
    > Configure your web server to point to the `public` directory of your project.

7. **Disable Maintenance Mode**:
    ```sh
    php artisan up
    ```
    > This will disable maintenance mode and make your application accessible again.

### Documentation
For database design, you can find it [here](https://dbdiagram.io/d/SCM-Batik-66ac8c9c8b4bb5230e09df06).

### User Roles and Access Endpoints

| User ID | Role   | Accessible Endpoints                        |
|---------|--------|---------------------------------------------|
| 1       | Admin  | `/users`, `/products`, `/orders`, `/reports` |
| 2       | Harvester| `/products`, `/orders`, `/reports`|
| 3       | Factory   | `/products`, `/orders`|
| 4       | Craftman  | `/users`, `/products`, `/orders`, `/reports` |
| 5       | Certificator| `/products`, `/orders`, `/reports`|
| 6       | Waste Manager   | `/products`, `/orders`|
| 7       | Distributor   | `/products`, `/orders`|

In the table above, we have defined three user roles: Admin, Harvester, and User. Each role has different access privileges to various endpoints in the web application.

- The Admin role (User ID 1) has access to all endpoints, including `/users`, `/products`, `/orders`, and `/reports`.
Please note that this is the actual endpoints and access privileges may vary based on your specific application role.
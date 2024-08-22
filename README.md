<h1 align="center">Batik Supply Chain Management App. </h1>

<p align="center">
Supply Chain Management App to managing the batik production supply chain. From sourcing raw materials to tracking finished goods, this app helps batik producers, suppliers, and distributors maintain a clear and efficient workflow.
</p>

<p align="center">
    <img src="https://media1.tenor.com/m/phXC2y9QVa0AAAAd/bocchi-the-rock-kita-ikuyo.gif" alt="Wife" width="400">
</p>

### Installation

To set up the project locally, follow these steps:

1. **Clone the Repository**:
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

4. **Generate Application Key**:
    ```sh
    php artisan key:generate
    ```
    > This will set the `APP_KEY` in your `.env` file, which is essential for securing sessions and encrypted data.

5. **Run Migrations**:
    ```sh
    php artisan migrate
    ```

6. **Run Seeders**:
    ```sh
    php artisan db:seed
    ```
    > This will populate the database with initial data for testing and development purposes.

7. **Create a Symbolic Link**:
    ```sh
    php artisan storage:link
    ```

8. **Start the Server**:
    ```sh
    php artisan serve
    ```
    > The server will start on the default port 8000. You can now access your web application by navigating to [http://localhost:8000](http://localhost:8000) in your web browser.


### Documentation
For database design, you can find it [here](https://dbdiagram.io/d/SCM-Batik-66ac8c9c8b4bb5230e09df06).

### User Roles and Access Endpoints

| Role ID | Role            |
|---------|-----------------|
| 1       | Admin           |
| 2       | Harvester       |
| 3       | Factory         |
| 4       | Craftman        |
| 5       | Certificator    |
| 6       | Waste Manager   |
| 7       | Distributor     |

- The Admin role (Role ID 1) has access to all endpoints
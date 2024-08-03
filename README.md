<h1 align="center">Batik Supply Chain Management App. </h1>

<p align="center">
Blockchain application on a web based supply chain management system
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

5. **Start the Server**:
    ```sh
    php artisan serve
    ```
    > The server will start on the default port 8000. You can now access your web application by navigating to [http://localhost:8000](http://localhost:8000) in your web browser.


### Documentation
For database design, you can find it [here](https://dbdiagram.io/d/SCM-Batik-66ac8c9c8b4bb5230e09df06).
# open-api-demo

An example application that demonstrates the use of OpenAPI for documenting API endpoints.

## Running the app locally

You need [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/).

1. **Build the image** (first time, or after changing `docker/Dockerfile`):

   ```bash
   docker compose build
   ```

2. **Create an Environment File**

   ```bash
   cp .env.example .env
   ```

3. **Install Dependencies**

    ```bash
    docker compose run --rm app composer install
    ```

4. **Prepare Local Data**

    ```bash
    docker compose run --rm app composer setup
    ```

5. **Start the app** (runs Laravel’s dev server inside the container):

   ```bash
   docker compose up
   ```

6. Open **http://localhost:8080** in your browser. The container maps host port `8080` to the dev server on port `8000`.

To run in the background:

```bash
docker compose up -d
```

Stop the stack with `Ctrl+C` in the foreground terminal, or with `docker compose down` if you used `-d`.

### API Credentials

Use the `app:testing-token` artisan command to retrieve an API token you can use for demonstration purposes.

```bash
docker compose run --rm app php artisan api:test-token
```

### Composer and Artisan in the container

Run one-off commands against the project directory with:

```bash
docker compose run --rm app composer install
docker compose run --rm app php artisan migrate
```

Replace the command after `app` with whatever you need (`composer require …`, `php artisan …`, etc.).

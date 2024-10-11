#Laravel 11 & Vue 3 Cutomer Management App

## Steps To install
1. Clone the repository
2. Copy .env.example to .env
3. Update the .env file with your database credentials
4. Update the .env file with the following:
    ```bash
    APP_URL={{ your app url }}
    ```
5. Run following commands:
    ```bash
    composer install
    php artisan migrate:fresh --seed
    npm install
    npm run dev
    ```

## API Documentation
Once the project is running, you can access the API documentation by visiting the following URL:
```
{{ your app url }}/docs/api
```

## TODO
- [ ] Add tests
- [ ] Check validation on the frontend
- [ ] Add Authentication to the API with Sanctum
- [ ] Add User Login and Authentication to the frontend with Vue Router
- [ ] Pretty up the frontend
- [ ] Prettify the code

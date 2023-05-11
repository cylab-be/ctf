# Cylab CTF

Capture The Flag engine...





## Contributing

Easiest way to launch a dev environment is using docker compose:

```bash
docker compose up

# create the default admin account
# email: ctf@example.org
# password: password
docker compose exec web php artisan db:seed

# create questions, challenges, users and submissions:
docker compose exec web php artisan db:seed --class MassSeeder
```


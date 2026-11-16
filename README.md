# Cylab CTF

**Cylab CTF** is a self-hosted platform to organize "quiz-style" capture-the-flag
events. An organizer creates a time-boxed challenge out of reusable question sets,
publishes a short access code, and participants register, answer questions, and
compete on a live scoreboard for points, awards and a certificate of completion.

Built with [Laravel 12](https://laravel.com) (PHP 8.2+) and a Bootstrap/jQuery
frontend, and shipped as a single Docker image (`cylab/ctf`).

## Features

### For organizers (admin)

- Create time-boxed challenges (PLANNED → RUNNING → FINISHED), start/stop them manually
- Compose challenges from reusable **sets** of **questions**
- Per-question points, maximum number of attempts (default: 3)
- Question statements in **Markdown**, with attached **files** (downloadable by participants)
- Answer (flag) matching via **case-insensitive regular expressions**
- Per-challenge **statistics** and a full solution view
- Manage users (including promotion to admin)
- Email participants when a challenge completes (MailHog in development)

### For participants

- Create an account and join a challenge with its **access code**
- Live progress (score percentage) and **live scoreboard** per challenge
- **Hall of fame** listing finished challenges
- **Awards**: first to score, quickest, best ratio, longest streak
- A **PDF certificate of completion** (with a QR code linking back to the scoreboard) once the challenge is finished

## Tech stack

| Layer     | Technology                                              |
|-----------|---------------------------------------------------------|
| Backend   | PHP 8.2+, Laravel 12, Eloquent                          |
| Database  | MySQL 8                                                 |
| Runtime   | Redis (sessions, cache, queue)                          |
| Frontend  | Bootstrap 4, jQuery, Sass — bundled with esbuild        |
| PDF       | TCPDF (completion certificates)                         |
| Packaging | Docker (dev + production), CI/CD with GitLab            |

## Data model

```
User ──< Registration >── Challenge ──m:n── Set ──< Question ──< QuestionFile
          │                │
          └─ score/rank    └─ code, time_start/end
                 │
                 └──< Submission >── Question
```

- **User** — account, optional admin flag
- **Challenge** — name, access code, start/end time, status (PLANNED / RUNNING / FINISHED)
- **Set** — a named, reusable group of questions (soft-deletable)
- **Question** — Markdown statement, flag (regex), points, max attempts, attached files
- **Registration** — a user's participation in a challenge; stores score and rank
- **Submission** — one answer attempt against a question
- **Awards** — computed per challenge from registrations (FirstPoint, Quickest, Ratio, Streak)

## Development

Prerequisites: Docker + Docker Compose.

1. Create the environment file (and adjust `UID`/`GID` to your own, see `id -u` / `id -g`):

   ```bash
   cp env.dev .env
   ```

2. Start the stack (migrations are applied automatically on container start):

   ```bash
   docker compose up
   ```

3. Create the default admin account:

   ```bash
   docker compose exec web php artisan db:seed
   ```

   > Login: `ctf@example.org` / `password` — change it after first login.

4. (Optional) load dummy questions, sets, challenges and users:

   ```bash
   docker compose exec web php artisan db:seed --class MassSeeder
   ```

### URLs

| Service | URL                   |
|---------|-----------------------|
| App     | http://127.0.0.1:8080 |
| MailHog | http://127.0.0.1:8025 |

The `node` service watches and rebuilds the frontend (JS/Sass) automatically.
If you prefer to manage assets yourself:

```bash
npm install
npm run build    # one-shot build
npm run watch    # rebuild on change
```

## Configuration

The `.env` file drives the configuration (see `env.dev` for a complete example).
The most relevant variables:

| Variable     | Purpose                                                       |
|--------------|---------------------------------------------------------------|
| `APP_URL`    | Public URL of the app (used in absolute URLs, e.g. certificates) |
| `MAIL_*`     | SMTP settings (point at MailHog in development)              |
| `DB_*`       | MySQL connection                                              |
| `REDIS_*`    | Redis host for sessions, cache and the queue                  |

## Testing & code quality

```bash
vendor/bin/phpunit    # run the test suite
vendor/bin/phpcs      # coding style (PSR-2 + custom rules)
vendor/bin/phpstan    # static analysis (level 5)
```

All three run automatically in the GitLab CI pipeline, which also builds the
`cylab/ctf` Docker image (and pushes it to the registry on git tags).

## License

MIT — see [LICENSE](LICENSE).

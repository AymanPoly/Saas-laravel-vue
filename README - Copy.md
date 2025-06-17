# AI Policy Generator

Generate tailored company policies (e.g., remote work, harassment, vacation, data security) in minutes using a modern Laravel + Vue.js web app.

---

## Features

- **AI Policy Generation:** Instantly create professional policy documents based on your company's details and requirements.
- **Policy Types:** Remote Work, Harassment, Vacation, Data Security (easily extendable).
- **Modern UI:** Clean, responsive Vue.js interface.
- **PDF Download:** Download generated policies as PDF files.
- **Extensible:** Ready for AI integration (e.g., OpenAI) and database storage.

---

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL/PostgreSQL/SQLite (for database features)
- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) (for PDF export)

### Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd saas-laravel-vue
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   ```

4. **Copy and configure your environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Edit .env for your DB and mail settings
   ```

5. **Install DomPDF:**
   ```bash
   composer require barryvdh/laravel-dompdf
   ```

6. **Build frontend assets:**
   ```bash
   npm run build
   ```

7. **Run migrations (if using database features):**
   ```bash
   php artisan migrate
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

---

## Usage

- Visit `http://localhost:8000`
- Fill in your company details and select a policy type
- Click **Generate Policy**
- Download the policy as a PDF

---

## Project Structure

- `resources/js/components/PolicyGenerator.vue` — Main Vue component for policy generation
- `app/Http/Controllers/PolicyController.php` — Handles policy generation and PDF export
- `routes/api.php` — API endpoints for policy generation and PDF download
- `resources/views/welcome.blade.php` — Home page with embedded policy generator

---

## Customization

- **Add more policy types:** Edit the `$templates` array in `PolicyController.php`
- **Integrate AI:** Replace the template logic with an API call to OpenAI or similar
- **Save to database:** Add a Policy model, migration, and update the controller

---

## Troubleshooting

- **PDF won't open?**  
  Ensure `barryvdh/laravel-dompdf` is installed and there are no errors in your controller or logs.

- **Frontend not updating?**  
  Run `npm run dev` or `npm run build` after changes.

---

## License

MIT

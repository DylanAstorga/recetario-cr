# Costa Rican Digital Recipe Book (Recetario Digital Costarricense)

A PHP web app to browse, search and add traditional Costa Rican recipes such as *gallo pinto*, *casado* and *olla de carne*. Data is stored in a JSON file, so it runs without a database.

> **ES:** Aplicación web en PHP para ver, buscar y agregar recetas tradicionales de Costa Rica. Los datos se guardan en un archivo JSON, sin base de datos.

## Features

- **Recipe catalog** with responsive cards (Bootstrap 5).
- **Recipe detail page** with ingredients and preparation steps.
- **Search** by name or category (case-insensitive).
- **Add recipes** through a form with server-side validation (required fields, valid http/https image URL). Each new recipe gets an auto-incremented ID.
- **JSON persistence** with file locking (`LOCK_EX`) to avoid corrupted writes.
- **XSS protection**: all output is escaped with `htmlspecialchars()`.

## Tech stack

PHP 8 · JSON · Bootstrap 5 · HTML/CSS

## Project structure

```
recetario-cr/
├── datos/recetas.json    # Recipe data
├── includes/
│   ├── funciones.php     # Read, save, search and find recipes by ID
│   ├── header.php
│   └── footer.php
├── css/estilos.css
├── index.php             # Catalog
├── receta.php            # Recipe detail
├── buscar.php            # Search
└── agregar.php           # Add a recipe
```

## How to run it locally

**Option A – XAMPP:** copy the folder into `xampp/htdocs/` and open `http://localhost/recetario-cr/`.

**Option B – PHP only:** inside the folder run `php -S localhost:8000` and open `http://localhost:8000`.

> The `datos/` folder must be writable to add new recipes.

## Author

**Dylan Astorga** – Computer Engineering student, Universidad Hispanoamericana (Costa Rica).

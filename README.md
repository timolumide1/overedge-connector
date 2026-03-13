# Overedge Connector

WordPress plugin that connects your site to a React frontend as a headless CMS.

## Installation (upload as zip)

1. **Zip the plugin correctly** so WordPress finds all files:
   - Zip the **folder** `overedge-plugin` (so the zip contains one top-level folder named `overedge-plugin`).
   - Inside that folder must be: `overedge.php` and the `includes` folder with all `.php` files.

   **Correct structure inside the zip:**
   ```
   overedge-plugin/
   ├── overedge.php
   ├── README.md
   └── includes/
       ├── activator.php
       ├── post-types.php
       ├── acf-fields.php
       ├── cors.php
       ├── options.php
       └── health.php
   ```

   **How to zip (Windows):** Right-click the `overedge-plugin` folder → “Compress to ZIP file”. Do not zip the contents while inside the folder (that would put `overedge.php` at the root of the zip and break the structure).

2. In WordPress: **Plugins → Add New → Upload Plugin**, choose the zip, then **Install Now** and **Activate**.

## Requirements

- WordPress 5.0+
- ACF Pro (for Site Settings and custom fields on testimonials, team, FAQs)

## REST API

- `GET /wp-json/overedge/v1/health` – plugin health and content counts  
- `GET /wp-json/overedge/v1/settings` – site-wide settings  
- `POST /wp-json/overedge/v1/configure` – set allowed origin (requires `X-Overedge-Secret` header)

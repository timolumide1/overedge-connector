=== Overedge Connector ===
Contributors: overedge
Tags: headless, rest-api, react, lovable, vite
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Connect your WordPress site to any React or Lovable-built frontend as a headless CMS — in minutes.

== Description ==

**Overedge Connector** is the bridge between your WordPress content and your React frontend.

Whether you built your site with Lovable, Vite, Next.js, or plain React — Overedge Connector turns your WordPress installation into a fully configured headless CMS that your React app can fetch from instantly.

= What It Does =

Once activated, Overedge Connector automatically:

* Registers **custom post types** — Testimonials, Team Members, and FAQs — all exposed via the REST API
* Configures **Advanced Custom Fields** field groups for each post type
* Enables and configures the **WordPress REST API** for headless use
* Handles **CORS headers** so your React frontend can fetch content cross-origin
* Creates a **site-wide options panel** for managing global settings (hero text, stats, CTAs, contact details)
* Exposes a **health endpoint** at `/wp-json/overedge/v1/health` so your frontend can monitor the connection
* Generates a **secret key** for secure webhook verification

= Who Is It For? =

* **Vibe coders** building client sites on Lovable who need their clients to manage content independently
* **Freelance developers** tired of rewriting WordPress REST API integrations on every project
* **Agencies** delivering consistent, client-friendly handovers at scale

= Works With Any React Frontend =

* Lovable subdomain (e.g. yoursite.lovable.app)
* Custom domain (e.g. yoursite.com)
* Next.js, Vite, Create React App — anything React

= Works With Any WordPress Setup =

* Subdomain (e.g. cms.yoursite.com)
* Main domain (e.g. yoursite.com)
* Subfolder (e.g. yoursite.com/cms)
* Shared hosting, VPS, managed WordPress — all supported

= Overedge Platform =

This plugin works standalone, but connects seamlessly with the **Overedge platform** (overedge.dev) which provides:

* Browser-based connection wizard — no terminal, no VS Code
* Auto-generated React integration files (wordpress.ts, useWordPress.ts, cmsData.ts)
* Dashboard to manage all connected sites
* Health monitoring across all your client sites
* Phase 2: Visual customisation — clients control colours, layout, and components from wp-admin
* Phase 2: Shortcode → React props mapping — `[overedge_hero headline="..."]` updates your React component automatically

= REST API Endpoints Added =

* `GET /wp-json/overedge/v1/health` — Plugin health and site status
* `POST /wp-json/overedge/v1/configure` — Update CORS allowed origin
* `GET /wp-json/overedge/v1/settings` — Site-wide CMS settings

= Custom Post Types Registered =

* `testimonials` — with fields: quote, author_name, author_country, destination, avatar
* `team_members` — with fields: full_name, job_title, bio, photo, destination_focus, linkedin_url
* `faqs` — with fields: answer, destination, order

All custom post types are exposed via the WordPress REST API and include ACF field support.

= Privacy =

This plugin does not collect or transmit any personal data. The optional Overedge platform connection only stores site URLs and connection status — never content or user data.

== Installation ==

= Automatic Installation (Recommended) =

1. Log in to your WordPress admin dashboard
2. Go to **Plugins → Add New**
3. Search for **Overedge Connector**
4. Click **Install Now**
5. Click **Activate Plugin**

That's it. The plugin configures everything automatically on activation.

= Manual Installation =

1. Download the plugin ZIP from this page
2. Go to **Plugins → Add New → Upload Plugin**
3. Upload the ZIP file and click **Install Now**
4. Click **Activate Plugin**

= After Activation =

1. Visit **Settings → Permalinks** and click **Save Changes** to flush rewrite rules
2. Test the health endpoint: `https://yoursite.com/wp-json/overedge/v1/health`
3. You should see a JSON response with `"status": "ok"`
4. Connect your React frontend using the Overedge platform at overedge.dev

== Frequently Asked Questions ==

= Does this plugin work without the Overedge platform? =

Yes. The plugin works standalone. It registers custom post types, configures the REST API, and handles CORS. You can connect any React frontend manually using the REST API endpoints.

The Overedge platform (overedge.dev) automates the connection setup and generates the React integration files for you — but it is optional.

= Does my React app need to be on a specific hosting platform? =

No. Overedge works with any React frontend on any hosting — Lovable, Vercel, Netlify, custom servers, or static hosting. Both subdomains and custom domains are supported.

= Do I need a custom domain for my WordPress site? =

No. The plugin works on any WordPress URL — a subdomain (cms.yoursite.com), a main domain (yoursite.com), or a subfolder (yoursite.com/cms).

= Does this plugin require Advanced Custom Fields? =

ACF field groups are registered programmatically using `acf_add_local_field_group()`. If ACF (free or Pro) is installed, the field groups appear automatically. If ACF is not installed, the custom post types still work via the REST API — you just won't have the structured ACF fields.

= How does CORS work? =

On activation, the plugin allows all origins by default so your React app can connect during setup. Once you connect via the Overedge platform, the allowed origin is updated to your specific React frontend URL only.

You can also set the allowed origin manually via the configure endpoint:
`POST /wp-json/overedge/v1/configure` with header `X-Overedge-Secret: [your secret key]`

= Where do I find my Overedge secret key? =

The secret key is auto-generated on plugin activation and stored as a WordPress option. You can retrieve it via WP-CLI: `wp option get overedge_secret_key`

= Is this plugin compatible with caching plugins? =

Yes. The REST API endpoints are excluded from page caching by default on most caching plugins. If you experience issues, add `/wp-json/` to your caching plugin's exclusion list.

= Does the plugin work on multisite? =

Single site support only in version 1.0. Multisite support is planned for a future release.

= How do I report a bug or request a feature? =

Visit overedge.dev or open an issue at github.com/overedge/overedge-connector

== Screenshots ==

1. The Overedge dashboard showing connected sites
2. The connection wizard — paste two URLs and connect
3. WordPress admin with Overedge custom post types
4. The health endpoint returning site status
5. React frontend fetching content from WordPress

== Changelog ==

= 1.0.0 =
* Initial release
* Custom post types: testimonials, team_members, faqs
* ACF field groups for all post types
* REST API configuration and CORS handling
* Health endpoint with query var fallback
* Site-wide options panel
* Secure configuration endpoint with secret key verification

== Upgrade Notice ==

= 1.0.0 =
Initial release. No upgrade required.

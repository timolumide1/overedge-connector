# Overedge Connector

> Connect any React or Lovable-built frontend to WordPress as a headless CMS — in minutes.

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0)
[![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net)
[![Version](https://img.shields.io/badge/Version-1.0.1-green)](https://github.com/timolumide1/overedge-connector)

---

## What Is Overedge Connector?

**Overedge Connector** is the WordPress plugin that powers the [Overedge](https://overedge.dev) platform — a browser-based tool that connects Lovable-built React frontends to WordPress as a headless CMS.

React and WordPress are treated as incompatible by default. One is JavaScript. One is PHP. Everyone says they don't belong together.

**Overedge goes over that edge.**

```
React Frontend          Overedge Connector       WordPress CMS
(Lovable / Vite)   ←──────────────────────→   (Your wp-admin)

studivahub.com     ←── REST API + CORS ────→   cms.studivahub.com
```

---

## What It Does

Once activated, the plugin automatically:

- ✅ Registers **custom post types** — Testimonials, Team Members, FAQs
- ✅ Configures **ACF field groups** for each post type
- ✅ Enables the **WordPress REST API** for headless use
- ✅ Handles **CORS headers** so your React app can fetch content
- ✅ Creates a **site-wide options panel** for global CMS settings
- ✅ Exposes a **health endpoint** for connection monitoring
- ✅ Generates a **secret key** for secure webhook verification

---

## Works With Any Stack

**React Frontend:**
```
✅ yoursite.lovable.app     (Lovable subdomain)
✅ yoursite.com             (custom domain)
✅ yoursite.vercel.app      (Vercel)
✅ yoursite.netlify.app     (Netlify)
✅ Any React / Vite / Next.js frontend
```

**WordPress Backend:**
```
✅ cms.yoursite.com         (subdomain)
✅ yoursite.com             (main domain)
✅ yoursite.com/cms         (subfolder)
✅ Shared hosting, VPS, managed WordPress
```

---

## Installation

### Automatic (Recommended)
1. Go to **WordPress Admin → Plugins → Add New**
2. Search for **Overedge Connector**
3. Click **Install Now** → **Activate**

### Manual
1. Download the ZIP from this repository
2. Go to **Plugins → Add New → Upload Plugin**
3. Upload the ZIP → **Install Now** → **Activate**

### After Activation
1. Go to **Settings → Permalinks** → click **Save Changes**
   *(flushes rewrite rules so REST routes register correctly)*
2. Test the health endpoint:
   ```
   https://yourcmsurl.com/wp-json/overedge/v1/health
   ```
3. Connect your React frontend via [overedge.dev](https://overedge.dev)

---

## REST API Endpoints

| Endpoint | Method | Auth | Description |
|----------|--------|------|-------------|
| `/wp-json/overedge/v1/health` | GET | Public | Plugin health and site status |
| `/wp-json/overedge/v1/configure` | POST | Secret key | Update CORS allowed origin |
| `/wp-json/overedge/v1/settings` | GET | Public | Site-wide CMS settings |

### Health Endpoint Response
```json
{
  "status": "ok",
  "plugin_version": "1.0.1",
  "wordpress_version": "6.9.4",
  "site_name": "Your Site Name",
  "allowed_origin": "https://yoursite.com",
  "secret_key_set": true,
  "post_types": {
    "posts": 12,
    "overedge_testimonials": 4,
    "overedge_team_members": 3,
    "overedge_faqs": 7
  },
  "rest_api_url": "https://cms.yoursite.com/wp-json/",
  "timestamp": "2026-03-13T01:52:45+00:00"
}
```

**Fallback URLs (if pretty permalinks are disabled):**
```
https://yourcmsurl.com/wp-json/wp/v2/overedge-health
https://yourcmsurl.com/?overedge_health=1
```

---

## Custom Post Types

Post types are registered as `overedge_testimonials`, `overedge_team_members`, and `overedge_faqs`. REST collection URLs stay short: `GET /wp-json/wp/v2/testimonials`, `.../team_members`, and `.../faqs` via `rest_base`.

### Testimonials (`overedge_testimonials`)
| Field | Type | Description |
|-------|------|-------------|
| `quote` | Textarea | The testimonial quote |
| `author_name` | Text | Author's name |
| `author_country` | Text | Author's country |
| `destination` | Select | germany / usa / both |
| `avatar` | Image | Author photo (returns URL) |

### Team Members (`overedge_team_members`)
| Field | Type | Description |
|-------|------|-------------|
| `full_name` | Text | Full name |
| `job_title` | Text | Job title |
| `bio` | Textarea | Short biography |
| `photo` | Image | Profile photo (returns URL) |
| `destination_focus` | Select | germany / usa / both |
| `linkedin_url` | URL | LinkedIn profile URL |

### FAQs (`overedge_faqs`)
| Field | Type | Description |
|-------|------|-------------|
| `answer` | Textarea | The answer text |
| `destination` | Select | germany / usa / both |
| `order` | Number | Display order |

---

## React Integration

Once connected via [overedge.dev](https://overedge.dev), you receive auto-generated React integration files:

**`wordpress.ts`** — API client
```typescript
const WP_API = 'https://cms.yoursite.com/wp-json/wp/v2';

export async function fetchBlogPosts(): Promise<BlogPost[]> {
  const posts = await wpFetch('posts', { per_page: '100', _embed: '1' });
  return posts.map(mapWPPostToBlogPost);
}
```

**`useWordPress.ts`** — React Query hooks
```typescript
export function useBlogPosts() {
  return useQuery({
    queryKey: ['wp', 'blogPosts'],
    queryFn: fetchBlogPosts,
    placeholderData: fallbackBlogPosts,
  });
}

// Available hooks:
// useBlogPosts()
// useTestimonials()
// useTeamMembers()
// useFAQs()
// usePageContent(slug)
// useSiteSettings()
```

**`cmsData.ts`** — Fallback data (prevents blank pages)

---

## CORS Configuration

By default the plugin allows all origins during setup. Once connected via Overedge, the allowed origin is automatically set to your React frontend URL.

To set manually:
```bash
POST /wp-json/overedge/v1/configure
Header: X-Overedge-Secret: your_secret_key
Body: { "allowed_origin": "https://yoursite.com" }
```

---

## Security

- WordPress admin credentials are **never stored** by Overedge
- A unique **secret key** is auto-generated on activation for webhook verification
- CORS is restricted to your **specific frontend domain** after connection
- All REST endpoints follow WordPress security best practices
- Plugin is fully **GPL v2** licensed and open source

---

## Requirements

| Requirement | Minimum Version |
|-------------|-----------------|
| WordPress | 5.8+ |
| PHP | 7.4+ |
| Advanced Custom Fields | 5.0+ (optional but recommended) |

---

## Live Example

**StudivaHub** (studivahub.com) is a live implementation of the Overedge architecture:

```
React Frontend:    studivahub.com
                   (Lovable/Vite app)
                        ↕
Overedge Connector installed at:
                        ↕
WordPress CMS:     cms.studivahub.com
                   (headless WordPress)
```

The site owner manages all content — blog posts, team profiles, testimonials, FAQs — from `cms.studivahub.com/wp-admin` independently, with zero developer involvement.

---

## Overedge Platform

This plugin works standalone but integrates with the **Overedge platform** at [overedge.dev](https://overedge.dev):

| Feature | Free | Developer ($19/mo) | Agency ($49/mo) |
|---------|------|-------------------|-----------------|
| Connect sites | 1 | Unlimited | Unlimited |
| Generated React files | ✅ | ✅ | ✅ |
| Visual customisation | ❌ | ✅ Phase 2 | ✅ Phase 2 |
| Shortcode → React props | ❌ | ✅ Phase 2 | ✅ Phase 2 |
| Managed WordPress hosting | ❌ | ❌ | ✅ Phase 3 |
| White-label wp-admin | ❌ | ❌ | ✅ Phase 3 |

---

## Changelog

### 1.0.1
- Unique `overco_` prefix for functions, constants, options, and related identifiers (WordPress.org guidelines)
- Prefixed CPT slugs: `overedge_testimonials`, `overedge_team_members`, `overedge_faqs`
- Prefixed ACF local field group and field keys
- REST namespace `overedge/v1`; configure with `X-Overedge-Secret` (legacy `X-Overco-Secret` still accepted)
- Migrates `overco_*` options to `overedge_*` on activation and removes the old keys

### 1.0.0
- Initial release
- Custom post types: testimonials, team_members, faqs
- ACF field groups for all post types
- REST API configuration and CORS handling
- Health endpoint with query var fallback
- Site-wide options panel
- Secure configuration endpoint with secret key

---

## Contributing

Contributions are welcome. Please open an issue or pull request on GitHub.

## License

GPL v2 or later — see [LICENSE](LICENSE) for details.

---

<p align="center">
  <strong>Overedge — Beyond the stack.</strong><br>
  <a href="https://overedge.dev">overedge.dev</a>
</p>

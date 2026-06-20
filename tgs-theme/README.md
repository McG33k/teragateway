# Tera-Gateway Synergies — WordPress Theme

Custom WordPress theme built to match the official TGS brand mockup.

---

## Installation

### Method 1 — Upload via WordPress Admin (recommended)

1. Download `tgs-theme.zip`
2. In WordPress admin: **Appearance → Themes → Add New → Upload Theme**
3. Upload the zip and click **Activate**

### Method 2 — FTP / File Manager

1. Extract the `tgs-theme` folder
2. Upload to `/wp-content/themes/tgs-theme/`
3. In WP Admin: **Appearance → Themes** → activate **Tera-Gateway Synergies**

---

## First-time Setup (do in order)

### 1. Set the front page
- **Settings → Reading → Your homepage displays → A static page**
- Create a blank page titled "Home" → select it as "Homepage"

### 2. Set up menus
- **Appearance → Menus → Create Menu**
- Create a menu with: Home · About Us · Services · Industries · Solutions · Contact Us
- Assign to **Primary Navigation**
- Create footer menus and assign to **Footer Quick Links** and **Footer Services**

### 3. Customise content
- **Appearance → Customize → TGS Theme Options**
  - **Hero Section**: Edit heading, sub-text, button, hero background image
  - **Stats Bar**: Edit the 4 stat numbers and labels
  - **CTA Banner**: Edit the call-to-action text and URL
  - **Contact Details**: Email, phone, website, address, social media URLs

### 4. Add your logo
- **Appearance → Customize → Site Identity → Logo**
- Recommended size: 200 × 96 px, PNG with transparent background

### 5. Add Services (optional CPT)
- **Services → Add New**
- Set title, excerpt (short description), featured image
- In the **Service Details** meta box: enter a Font Awesome 6 icon class (e.g. `fa-solid fa-cloud`)
  - Find icons at: https://fontawesome.com/icons
- Set Display Order (1–8) to control grid position
- When at least one Service post is published, the hardcoded defaults are replaced automatically

### 6. Hero background image
- **Customize → TGS Theme Options → Hero Section → Hero Background Image**
- Recommended: 1440 × 700 px, tech/digital subject matter
- The navy overlay is applied automatically via CSS

---

## Plugin Recommendations

| Purpose | Plugin |
|---|---|
| Contact forms | WPForms Lite or Contact Form 7 |
| SEO | Yoast SEO or Rank Math |
| Performance | WP Rocket or W3 Total Cache |
| Image optimization | Smush or ShortPixel |
| Security | Wordfence |
| Backup | UpdraftPlus |

---

## Theme Files

```
tgs-theme/
├── style.css              ← Theme header + all CSS
├── functions.php          ← Setup, CPTs, Customizer, meta boxes
├── header.php             ← <head>, header, nav
├── footer.php             ← Footer columns, copyright bar, wp_footer
├── front-page.php         ← Homepage (Hero → Services → Stats → About → Industries → CTA)
├── index.php              ← Blog/archive fallback
├── page.php               ← Generic page template
├── single.php             ← Single post template
├── screenshot.png         ← Theme preview (1200×900)
└── assets/
    ├── css/               ← (additional CSS files if needed)
    └── js/
        └── main.js        ← Nav toggle, scroll animations, counter
```

---

## Colours & Fonts

| Token | Value |
|---|---|
| Navy (primary) | `#1A3C8F` |
| Dark Navy | `#0D1B4B` |
| Red (accent) | `#E63329` |
| Light BG | `#F5F7FF` |
| Body text | `#2C2C2C` |
| Muted text | `#5A6A7E` |
| Display font | Poppins (600, 700, 800) |
| Body font | Inter (400, 500, 600) |

---

## Customization

All color values are CSS custom properties in `:root {}` at the top of `style.css`.
Changing `--tgs-navy` or `--tgs-red` cascades through the entire theme.

---

## Browser Support

Chrome 90+, Firefox 88+, Safari 14+, Edge 90+, iOS Safari 14+, Android Chrome 90+

---

## License

Proprietary — Tera-Gateway Synergies. All rights reserved.

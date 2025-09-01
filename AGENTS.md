# Repository Guidelines

## Project Structure & Module Organization
- Root equals the theme directory. Key files: `style.css`, `functions.php`, `index.php`, `front-page.php`, `single.php`, `page.php`, `archive.php`, `search.php`, `404.php`, `header.php`, `footer.php`, `searchform.php`.
- Assets live in `images/` (e.g., `images/avatar.jpg`).
- No build pipeline; this is a classic PHP/CSS WordPress theme. Install under `wp-content/themes/rselbach/`.

## Build, Test, and Development Commands
- Lint PHP: `find . -name "*.php" -print0 | xargs -0 -n1 php -l` — syntax checks all PHP files.
- Optional PHPCS (WordPress rules): `phpcs --standard=WordPress --extensions=php .` — ensure WP Coding Standards.
- Local WP (optional): `npx @wordpress/env start` — spins up a dev WordPress; activate the `Rselbach` theme.

## Coding Style & Naming Conventions
- PHP: 4‑space indent, brace on same line, single quotes where possible.
- Prefix: use `rselbach_` for all functions, hooks, and settings (e.g., `rselbach_customize_register`).
- I18n: use text domain `rselbach` with `__()`, `_e()`, etc.
- Escaping/Sanitization: escape on output (`esc_html`, `esc_url`, `wp_kses_post`) and sanitize on save (`sanitize_text_field`, `sanitize_hex_color`).
- Templates: follow WordPress template naming (e.g., `template-*.php` with a `Template Name:` header when creating custom templates).

## Testing Guidelines
- No automated tests yet. Verify manually in a local WordPress:
  - Activate theme; check homepage, posts, archives, search, and 404.
  - Confirm Customizer options (accent/decoration colors, avatar, GA ID, social links) apply across pages.
  - Accessibility pass: keyboard nav, focus states, alt text on images.
  - Performance: confirm assets are minified where relevant and GA loads async when configured.

## Commit & Pull Request Guidelines
- Commits: present tense, concise, scoped (e.g., "Fix header spacing on mobile"). Group related changes only.
- PRs: include summary, rationale, screenshots of UI changes, and testing steps. Link related issues. Keep diffs small and focused.

## Security & Configuration Tips
- Never trust user input; continue to escape/sanitize consistently.
- Respect WordPress pluggable hooks/filters; avoid globals and function name collisions via the `rselbach_` prefix.
- Do not commit secrets; GA IDs belong in the Customizer.


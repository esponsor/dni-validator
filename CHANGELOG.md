## [0.1.1] - 2026-08-11

### Security
- **Chile RUT (JS/PHP):** reject oversized bodies and calculate the check digit from characters instead of converting the whole body to a number. The previous JS path could infinite-loop when `parseInt` produced `Infinity` on huge input (DoS if untrusted request data was validated server-side).
- **Chile RUT `validate()`:** only accept digits and conventional separators (dots, hyphens, spaces, `K`). `clean()` still strips other characters for formatting helpers; wrapping markup such as `<script>…</script>` no longer validates.

### Tooling
- Removed the root `prepare` hook that ran a nested `npm install` during publish/git installs.
- Added `release-npm.yml` for GitHub Release → npm publish with OIDC/`--provenance` (configure Trusted Publishing on npm).
- Pinned GitHub Actions to full commit SHAs.
- Expanded `.gitignore` for env/auth/editor junk; marked 0.0.x unsupported in `SECURITY.md`.

## [0.1.0] - 2026-08-11

Added validators for Argentina (CUIT/CUIL), Brazil (CPF, CNPJ), Canada (SIN), Colombia (CC, NIT, PASS), Ecuador (CI, RUT, PASS), Peru (DNI, RUC), Spain (DNI/NIE), the United States and Puerto Rico (SSN) and Uruguay (CI, RUT), in PHP and TypeScript.
Added a Laravel validation rule per document and registered every document in both registries; country and type lookups are now case insensitive.
Added country subpath exports to the JS package and shared JSON test vectors that drive both test suites through the registry.
Documented which documents are validated structurally instead of by checksum.
Fixed: CPF rejects repeated-digit values, Uruguayan CI requires 7-8 digits before the check digit, and Peruvian DNI requires 8 digits plus an optional verification character.
Existing Chile RUT and Mexico CURP APIs are unchanged.

Tooling / OSS readiness:
- Bumped Pest to `^3.0` and committed `composer.lock` so PHP installs resolve again.
- Added GitHub Actions CI for PHP 8.4–8.5 and Node 22.
- Clarified that npm publishes from the repo root (`packages/js` is private).
- Added `CONTRIBUTING.md` and `SECURITY.md`.
- Bumped Vitest to v3 (npm audit clean for the JS workspace).

## [0.0.1] - 2026-05-18

Initial release — CL (RUT) and MX (CURP) validators
PHP + JS packages with shared test vectors

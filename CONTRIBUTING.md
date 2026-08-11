# Contributing

Thanks for helping improve `dni-validator`.

## Layout

| Path | Role |
|------|------|
| `packages/php/src` | PHP validators and Laravel rules (Packagist package root is the repo root `composer.json`) |
| `packages/js/src` | TypeScript sources (private workspace; **publish npm from the repo root**) |
| `tests/vectors` | Shared JSON fixtures used by both runtimes |

## Setup

```bash
# PHP
composer install
composer test   # or: vendor/bin/pest / npm run test:php

# JavaScript
npm --prefix packages/js install
npm test        # or: npm --prefix packages/js test
npm run build
```

Requires PHP `^8.4`, Composer 2, and Node 22+.

## Adding a document

1. Implement the validator in PHP and TypeScript with matching `validate` / `clean` / `format` behaviour where applicable.
2. Register it in `DocumentValidatorRegistry` and the JS `registry`.
3. Add a Laravel rule extending `DocumentRule`.
4. Add `tests/vectors/<cc>-<type>.json` with `valid`, `invalid`, and optional `formats`.
5. Update the supported-documents table in `README.md` and `CHANGELOG.md`.

If a document has no public checksum, mark it **Structural only** or **Length only** in the README and in the validator docblock.

## Pull requests

- Keep PHP and JS behaviour in lockstep via the shared vectors.
- CI runs Pest and Vitest on every PR; both must stay green.
- Do not commit `vendor/`, `node_modules/`, or `packages/js/dist/`.

## Publishing (maintainers)

- **Packagist**: create a git tag / GitHub Release; Packagist reads the root `composer.json`.
- **npm**: prefer GitHub Release → `.github/workflows/release-npm.yml` with [Trusted Publishing](https://docs.npmjs.com/trusted-publishers) configured for this repo/workflow (no long-lived `NPM_TOKEN`). Manual fallback from the repo root: `npm --prefix packages/js ci && npm run build && npm publish --access public`.
- Do not publish `packages/js` (it is private).

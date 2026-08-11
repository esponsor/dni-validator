# Document specs

Language-independent specifications for each supported document. JS and PHP
implementations load these files in tests; behaviour must stay in lockstep.

## Layout

```text
spec/<cc>/<type-slug>.json
```

Country code is lowercase ISO 3166-1 alpha-2 (`br`, `cl`, …). The filename is a
lowercase slug of the registry type (`cpf`, `cuit-cuil`, `pass`).

## Schema

| Field | Required | Description |
|-------|----------|-------------|
| `country` | yes | Uppercase country code matching the registry (`BR`) |
| `type` | yes | Uppercase registry type key (`CPF`, `CUIT/CUIL`, `PASS`) |
| `name` | yes | Human-readable document name |
| `subject` | yes | Who the identifier applies to: `person`, `organization`, or `either` |
| `validation` | yes | `checksum`, `structural`, or `length` |
| `patterns` | no | Example display/input masks only — **not** regex and **not** asserted by `validate()` |
| `valid` | yes | Strings that must pass `validate()` |
| `invalid` | yes | Objects `{ "value", "reason" }` that must fail `validate()` |
| `format_cases` | no | Map of input → expected `format()` output |

### `reason` values

| Reason | Meaning |
|--------|---------|
| `checksum` | Wrong check digit / letter |
| `length` | Wrong size |
| `format` | Invalid characters or representation |
| `component` | Invalid internal rule (repeated digits, bad prefix, reserved range, …) |
| `other` | Exceptional only |

Tests currently assert accept/reject on `value` only. `reason` is validated as
an allowed enum at load time.

## Adding a document

1. Add `spec/<cc>/<slug>.json` following this schema.
2. Implement the validator in PHP and TypeScript.
3. Register it in both registries and (for PHP) add a Laravel rule.
4. Update the README supported-documents table and CHANGELOG.

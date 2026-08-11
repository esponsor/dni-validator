# dni-validator

[![CI](https://github.com/esponsor/dni-validator/actions/workflows/ci.yml/badge.svg)](https://github.com/esponsor/dni-validator/actions/workflows/ci.yml)
[![npm](https://img.shields.io/npm/v/@esponsor/dni-validator)](https://www.npmjs.com/package/@esponsor/dni-validator)
[![Packagist](https://img.shields.io/packagist/v/esponsor/dni-validator)](https://packagist.org/packages/esponsor/dni-validator)
[![License](https://img.shields.io/github/license/esponsor/dni-validator)](LICENSE)

Validators for Latin American and related national ID documents.
Available as both a **PHP/Laravel** package and a **JavaScript/TypeScript** package.
Both packages implement the same rules and are covered by the same shared test vectors.

## Supported documents

| Country | Type | Validation | PHP class | JS import |
|---------|------|------------|-----------|-----------|
| 🇦🇷 Argentina | `CUIT/CUIL` | Prefix + modulo-11 check digit | `CuitCuilArgentina` | `/argentina` |
| 🇧🇷 Brazil | `CPF` | Two modulo-11 check digits | `CpfBrazil` | `/brazil` |
| 🇧🇷 Brazil | `CNPJ` | Two modulo-11 check digits | `CnpjBrazil` | `/brazil` |
| 🇨🇦 Canada | `SIN` | Luhn check digit | `SinCanada` | `/canada` |
| 🇨🇱 Chile | `RUT` | Modulo-11 check digit | `RutChile` | `/chile` |
| 🇨🇴 Colombia | `CC` | **Structural only** — 8 or 10 digits | `CcColombia` | `/colombia` |
| 🇨🇴 Colombia | `NIT` | **Structural only** — 10 digits, check digit not verified | `NitColombia` | `/colombia` |
| 🇨🇴 Colombia | `PASS` | **Length only** — 2 to 12 characters | `PassportColombia` | `/colombia` |
| 🇪🇨 Ecuador | `CI` | **Structural only** — 10 digits, check digit not verified | `CiEcuador` | `/ecuador` |
| 🇪🇨 Ecuador | `RUT` | **Structural only** — 13 digits, check digit not verified | `RutEcuador` | `/ecuador` |
| 🇪🇨 Ecuador | `PASS` | **Length only** — 8 to 12 characters | `PassportEcuador` | `/ecuador` |
| 🇪🇸 Spain | `DNI` | Modulo-23 check letter (covers DNI and NIE) | `DniSpain` | `/spain` |
| 🇲🇽 Mexico | `CURP` | Regex + weighted checksum | `CurpMexico` | `/mexico` |
| 🇵🇪 Peru | `DNI` | **Structural only** — 8 digits plus optional verification character | `DniPeru` | `/peru` |
| 🇵🇪 Peru | `RUC` | **Structural only** — 11 digits with a known taxpayer prefix | `RucPeru` | `/peru` |
| 🇺🇸 United States / 🇵🇷 Puerto Rico | `SSN` | **Structural only** — rejects ranges the SSA never issues | `SsnUnitedStates` | `/united-states` |
| 🇺🇾 Uruguay | `CI` | Weighted check digit | `CiUruguay` | `/uruguay` |
| 🇺🇾 Uruguay | `RUT` | Modulo-11 check digit | `RutUruguay` | `/uruguay` |

Rows marked **Structural only** or **Length only** verify shape or length, not a checksum:
a well-formed value can still be a number that was never issued.

---

## PHP

### Install

```bash
composer require esponsor/dni-validator
```

Requires PHP `^8.4` and `illuminate/contracts` `^10|^11|^12`.

### Direct usage

Every validator exposes `validate()`. Most also expose `clean()` (strip formatting) and
`format()` (apply the country's display format); passport validators only expose `validate()`,
and `RutEcuador` has no display format.

```php
use Esponsor\DniValidator\CpfBrazil;
use Esponsor\DniValidator\RutChile;

$rut = new RutChile();
$rut->validate('11.111.111-1'); // true
$rut->clean('11.111.111-1');    // '111111111'
$rut->format('111111111');      // '11.111.111-1'

$cpf = new CpfBrazil();
$cpf->validate('111.444.777-35'); // true
$cpf->format('11144477735');      // '111.444.777-35'
```

### Laravel validation rules

Each validator has a matching rule under `Esponsor\DniValidator\Rules` named after the
validator class (`CpfBrazil` → `CpfBrazilRule`). Rules reject non-string values and fail with a
Spanish message.

```php
use Esponsor\DniValidator\Rules\CpfBrazilRule;
use Esponsor\DniValidator\Rules\RutChileRule;

$request->validate([
    'rut' => ['required', 'string', new RutChileRule()],
    'cpf' => ['required', 'string', new CpfBrazilRule()],
]);
```

### Registry

Country and document type are matched case insensitively.

```php
use Esponsor\DniValidator\DocumentValidatorRegistry;

DocumentValidatorRegistry::validate('CL', 'RUT', '11.111.111-1');      // true
DocumentValidatorRegistry::validate('ar', 'cuit/cuil', '20-12345678-6'); // true

$validator = DocumentValidatorRegistry::for('UY', 'RUT');
$validator->format('211003360014'); // '21-100336-001-4'

DocumentValidatorRegistry::for('CL', 'UNKNOWN'); // null
```

### Running PHP tests

```bash
composer install
vendor/bin/pest
```

---

## JavaScript / TypeScript

### Install

```bash
npm install @esponsor/dni-validator
```

Requires Node 22+. The published npm package is the **repo root** `package.json`; `packages/js` holds sources and tests only.

### Named imports

Import from the country subpath, or from the package root for everything at once. Function
names are suffixed with the country when the same document type exists in several countries
(`ciUruguayValidate`, `ciEcuadorValidate`, `dniPeruValidate`, `dniSpainValidate`).

```ts
import { rutValidate, rutFormat } from '@esponsor/dni-validator/chile';
import { cpfValidate, cnpjValidate } from '@esponsor/dni-validator/brazil';
import { rutUruguayValidate, ciUruguayValidate } from '@esponsor/dni-validator/uruguay';

rutValidate('11.111.111-1');  // true
cpfValidate('111.444.777-35'); // true
```

### Registry

Country and document type are matched case insensitively.

```ts
import { getValidator } from '@esponsor/dni-validator';

const validator = getValidator('uy', 'rut');
validator?.validate('211003360014'); // true
validator?.format?.('211003360014'); // '21-100336-001-4'

getValidator('CL', 'UNKNOWN'); // null
```

### Running JS tests

```bash
npm --prefix packages/js install
npm test
```

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md). Security reports: [SECURITY.md](SECURITY.md).

## Shared test vectors

`tests/vectors/*.json` holds one file per document with its `country`, `type`, `valid`,
`invalid` and optional `formats` cases. Both test suites read these files and drive the
validators through the registry, so the two runtimes cannot drift apart.

## Behaviour notes

These validators were ported from the eSponsor front-end helper. The following differences are
deliberate fixes:

- **BR CPF** rejects repeated-digit values such as `111.111.111-11`, which pass the checksum but
  are not issued. `CNPJ` already rejected them.
- **UY CI** requires 7 or 8 digits before checking the digit. Without the length guard a
  12-digit Uruguayan RUT could be accepted as a CI.
- **PE DNI** requires 8 digits plus an optional verification character, instead of any 8 to 9
  characters drawn from `0-9` and `A-K`.
- **ES DNI/NIE** and **PE DNI** normalise their input (uppercase, punctuation stripped) before
  validating, like every other validator in the package.
- **PE DNI** `format()` groups 8 digits plus the verification character (`12345678-K`), matching
  the documented placeholder.

---

## License

MIT — Copyright (c) 2026 eSponsor

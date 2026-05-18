# dni-validator

Validators for Latin American and related national ID documents.
Available as both a **PHP/Laravel** package and a **JavaScript/TypeScript** package.

## Supported documents

| Country | Type | Description |
|---------|------|-------------|
| 🇨🇱 Chile | RUT | Rol Único Tributario — modulo-11 check digit |
| 🇲🇽 Mexico | CURP | Clave Única de Registro de Población — regex + weighted checksum |

More countries coming in future releases.

---

## PHP

### Install

```bash
composer require esponsor/dni-validator
```

Requires PHP `^8.2` and `illuminate/contracts` `^10|^11|^12`.

### Direct usage

```php
use Esponsor\DniValidator\RutChile;
use Esponsor\DniValidator\CurpMexico;

$rut = new RutChile();
$rut->validate('11.111.111-1'); // true
$rut->validate('11.111.111-2'); // false
$rut->clean('11.111.111-1');   // '111111111'
$rut->format('111111111');     // '11.111.111-1'

$curp = new CurpMexico();
$curp->validate('GICJ020605HDGRHNA2'); // true
$curp->format('gicj020605hdgrhna2');   // 'GICJ020605HDGRHNA2'
```

### Laravel validation rules

```php
use Esponsor\DniValidator\Rules\RutChileRule;
use Esponsor\DniValidator\Rules\CurpMexicoRule;

$request->validate([
    'rut'  => ['required', 'string', new RutChileRule()],
    'curp' => ['required', 'string', new CurpMexicoRule()],
]);
```

Error messages are in Spanish:
- `El RUT ingresado no es válido.`
- `El CURP ingresado no es válido.`

### Registry

```php
use Esponsor\DniValidator\DocumentValidatorRegistry;

$validator = DocumentValidatorRegistry::for('CL', 'RUT');
$validator->validate('11.111.111-1'); // true

DocumentValidatorRegistry::validate('MX', 'CURP', 'GICJ020605HDGRHNA2'); // true
DocumentValidatorRegistry::for('CL', 'UNKNOWN'); // null
```

### Running PHP tests

```bash
cd packages/php
composer install
./vendor/bin/pest
```

---

## JavaScript / TypeScript

### Install

```bash
npm install @esponsor/dni-validator
```

Requires Node 20+.

### Named imports

```ts
import { rutValidate, rutFormat, rutClean } from '@esponsor/dni-validator/chile';
import { curpValidate, curpFormat, curpClean } from '@esponsor/dni-validator/mexico';

rutValidate('11.111.111-1'); // true
rutFormat('111111111');      // '11.111.111-1'

curpValidate('GICJ020605HDGRHNA2'); // true
curpFormat('gicj020605hdgrhna2');   // 'GICJ020605HDGRHNA2'
```

### Registry

```ts
import { getValidator } from '@esponsor/dni-validator';

const validator = getValidator('CL', 'RUT');
validator?.validate('11.111.111-1'); // true
validator?.format?.('111111111');    // '11.111.111-1'

getValidator('CL', 'UNKNOWN'); // null
```

### Running JS tests

```bash
cd packages/js
npm install
npm test
```

---

## License

MIT — Copyright (c) 2026 eSponsor

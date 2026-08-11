import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';
import { describe, expect, it } from 'vitest';
import { rutClean, rutFormat, rutValidate } from '../src/chile/rut.js';

const vectors = JSON.parse(
  readFileSync(resolve(__dirname, '../../../tests/vectors/cl-rut.json'), 'utf-8'),
) as { valid: string[]; invalid: string[] };

describe('rutClean', () => {
  it('strips formatting and uppercases', () => {
    expect(rutClean('11.111.111-1')).toBe('111111111');
    expect(rutClean('9.083.469-K')).toBe('9083469K');
  });
});

describe('rutFormat', () => {
  it('formats cleaned values', () => {
    expect(rutFormat('111111111')).toBe('11.111.111-1');
    expect(rutFormat('9083469K')).toBe('9.083.469-K');
  });
});

describe('rutValidate vectors', () => {
  it.each(vectors.valid)('accepts valid RUT %s', (value) => {
    expect(rutValidate(value)).toBe(true);
  });

  it.each(vectors.invalid)('rejects invalid RUT %s', (value) => {
    expect(rutValidate(value)).toBe(false);
  });
});

describe('rutValidate adversarial input', () => {
  it.each([100, 1_000, 100_000])('rejects %s-digit bodies without hanging', (size) => {
    const started = Date.now();
    expect(rutValidate(`${'9'.repeat(size)}-1`)).toBe(false);
    expect(Date.now() - started).toBeLessThan(1_000);
  });

  it('rejects Infinity-prone oversized digit strings quickly', () => {
    const started = Date.now();
    expect(rutValidate('9'.repeat(310))).toBe(false);
    expect(Date.now() - started).toBeLessThan(1_000);
  });

  it('rejects valid RUT wrapped in arbitrary characters', () => {
    expect(rutValidate('<script>11.111.111-1</script>')).toBe(false);
  });
});

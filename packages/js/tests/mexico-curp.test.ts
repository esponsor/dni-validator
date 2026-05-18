import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';
import { describe, expect, it } from 'vitest';
import { curpCheckDigit, curpClean, curpFormat, curpValidate } from '../src/mexico/curp.js';

const vectors = JSON.parse(
  readFileSync(resolve(__dirname, '../../../tests/vectors/mx-curp.json'), 'utf-8'),
) as { valid: string[]; invalid: string[] };

describe('curpClean', () => {
  it('uppercases and strips non-alphanumeric characters', () => {
    expect(curpClean('GICJ020605HDGRHNA2')).toBe('GICJ020605HDGRHNA2');
    expect(curpClean('gicj-020605-hdgrhna2')).toBe('GICJ020605HDGRHNA2');
  });
});

describe('curpFormat', () => {
  it('returns the cleaned uppercase value', () => {
    expect(curpFormat('gicj-020605-hdgrhna2')).toBe('GICJ020605HDGRHNA2');
  });
});

describe('curpCheckDigit', () => {
  it('computes known check digits', () => {
    expect(curpCheckDigit('GICJ020605HDGRHNA2')).toBe(2);
    expect(curpCheckDigit('BOOL051031MDFRRNA8')).toBe(8);
  });
});

describe('curpValidate vectors', () => {
  it.each(vectors.valid)('accepts valid CURP %s', (value) => {
    expect(curpValidate(value)).toBe(true);
  });

  it.each(vectors.invalid)('rejects invalid CURP %s', (value) => {
    expect(curpValidate(value)).toBe(false);
  });
});

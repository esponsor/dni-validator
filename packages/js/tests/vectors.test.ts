import { readFileSync, readdirSync } from 'node:fs';
import { resolve } from 'node:path';
import { describe, expect, it } from 'vitest';
import { getValidator } from '../src/registry.js';

type Vector = {
  country: string;
  type: string;
  valid: string[];
  invalid: string[];
  formats?: Record<string, string>;
};

const vectorsDir = resolve(__dirname, '../../../tests/vectors');

const vectors: Vector[] = readdirSync(vectorsDir)
  .filter((file) => file.endsWith('.json'))
  .map((file) => JSON.parse(readFileSync(resolve(vectorsDir, file), 'utf-8')) as Vector);

describe.each(vectors)('$country $type vectors', (vector) => {
  const validator = getValidator(vector.country, vector.type);

  it('is registered', () => {
    expect(validator).not.toBeNull();
  });

  it.each(vector.valid)('accepts %s', (value) => {
    expect(validator?.validate(value)).toBe(true);
  });

  it.each(vector.invalid)('rejects %s', (value) => {
    expect(validator?.validate(value)).toBe(false);
  });

  const formats = Object.entries(vector.formats ?? {});

  if (formats.length > 0) {
    it.each(formats)('formats %s as %s', (input, expected) => {
      expect(validator?.format?.(input)).toBe(expected);
    });
  }
});

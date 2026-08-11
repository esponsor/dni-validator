import { readFileSync, readdirSync } from 'node:fs';
import { join, resolve } from 'node:path';
import { describe, expect, it } from 'vitest';
import { getValidator } from '../src/registry.js';
import { assertValidSpec, type DocumentSpec } from './assert-spec.js';

const specRoot = resolve(__dirname, '../../../spec');

function collectSpecFiles(dir: string): string[] {
  const entries = readdirSync(dir, { withFileTypes: true });
  const files: string[] = [];

  for (const entry of entries) {
    const path = join(dir, entry.name);

    if (entry.isDirectory()) {
      files.push(...collectSpecFiles(path));
      continue;
    }

    if (entry.isFile() && entry.name.endsWith('.json')) {
      files.push(path);
    }
  }

  return files.sort();
}

const specs: DocumentSpec[] = collectSpecFiles(specRoot).map((path) => {
  const spec = JSON.parse(readFileSync(path, 'utf-8')) as unknown;
  assertValidSpec(spec, path);
  return spec;
});

describe.each(specs)('$country $type vectors', (spec) => {
  const validator = getValidator(spec.country, spec.type);

  it('is registered', () => {
    expect(validator).not.toBeNull();
  });

  it.each(spec.valid)('accepts %s', (value) => {
    expect(validator?.validate(value)).toBe(true);
  });

  it.each(spec.invalid.map((entry) => [entry.value, entry.reason] as const))(
    'rejects %s (%s)',
    (value) => {
      expect(validator?.validate(value)).toBe(false);
    },
  );

  const formatCases = Object.entries(spec.format_cases ?? {});

  if (formatCases.length > 0) {
    it.each(formatCases)('formats %s as %s', (input, expected) => {
      expect(validator?.format?.(input)).toBe(expected);
    });
  }
});

const SUBJECTS = new Set(['person', 'organization', 'either']);
const VALIDATIONS = new Set(['checksum', 'structural', 'length']);
const REASONS = new Set(['checksum', 'length', 'format', 'component', 'other']);

export type InvalidCase = {
  value: string;
  reason: string;
};

export type DocumentSpec = {
  country: string;
  type: string;
  name: string;
  subject: string;
  validation: string;
  patterns?: string[];
  valid: string[];
  invalid: InvalidCase[];
  format_cases?: Record<string, string>;
};

function isPlainObject(value: unknown): value is Record<string, unknown> {
  return typeof value === 'object' && value !== null && !Array.isArray(value);
}

function assertString(value: unknown, label: string, path: string): asserts value is string {
  if (typeof value !== 'string' || value.length === 0) {
    throw new Error(`${path}: ${label} must be a non-empty string`);
  }
}

function assertStringArray(value: unknown, label: string, path: string): asserts value is string[] {
  if (!Array.isArray(value) || value.some((entry) => typeof entry !== 'string')) {
    throw new Error(`${path}: ${label} must be an array of strings`);
  }
}

export function assertValidSpec(value: unknown, path: string): asserts value is DocumentSpec {
  if (!isPlainObject(value)) {
    throw new Error(`${path}: spec must be a JSON object`);
  }

  assertString(value.country, 'country', path);
  assertString(value.type, 'type', path);
  assertString(value.name, 'name', path);
  assertString(value.subject, 'subject', path);
  assertString(value.validation, 'validation', path);

  if (!SUBJECTS.has(value.subject)) {
    throw new Error(`${path}: subject must be one of ${[...SUBJECTS].join(', ')}`);
  }

  if (!VALIDATIONS.has(value.validation)) {
    throw new Error(`${path}: validation must be one of ${[...VALIDATIONS].join(', ')}`);
  }

  assertStringArray(value.valid, 'valid', path);

  if (!Array.isArray(value.invalid)) {
    throw new Error(`${path}: invalid must be an array`);
  }

  for (const [index, entry] of value.invalid.entries()) {
    if (!isPlainObject(entry)) {
      throw new Error(`${path}: invalid[${index}] must be an object with value and reason`);
    }

    assertString(entry.value, `invalid[${index}].value`, path);
    assertString(entry.reason, `invalid[${index}].reason`, path);

    if (!REASONS.has(entry.reason)) {
      throw new Error(
        `${path}: invalid[${index}].reason must be one of ${[...REASONS].join(', ')}`,
      );
    }
  }

  if (value.patterns !== undefined) {
    assertStringArray(value.patterns, 'patterns', path);
  }

  if (value.format_cases !== undefined) {
    if (!isPlainObject(value.format_cases)) {
      throw new Error(`${path}: format_cases must be an object`);
    }

    for (const [input, expected] of Object.entries(value.format_cases)) {
      if (typeof expected !== 'string') {
        throw new Error(`${path}: format_cases[${input}] must be a string`);
      }
    }
  }
}

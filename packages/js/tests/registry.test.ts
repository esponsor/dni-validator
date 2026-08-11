import { describe, expect, it } from 'vitest';
import { getValidator } from '../src/registry.js';

describe('getValidator', () => {
  it('returns a Chile RUT validator', () => {
    const validator = getValidator('CL', 'RUT');

    expect(validator).not.toBeNull();
    expect(validator?.validate('11.111.111-1')).toBe(true);
    expect(validator?.format?.('111111111')).toBe('11.111.111-1');
  });

  it('returns a Mexico CURP validator', () => {
    const validator = getValidator('MX', 'CURP');

    expect(validator).not.toBeNull();
    expect(validator?.validate('GICJ020605HDGRHNA2')).toBe(true);
  });

  it('shares the SSN validator between the United States and Puerto Rico', () => {
    expect(getValidator('US', 'SSN')).toBe(getValidator('PR', 'SSN'));
  });

  it('looks up country and type case insensitively', () => {
    expect(getValidator('cl', 'rut')?.validate('11.111.111-1')).toBe(true);
    expect(getValidator('ar', 'cuit/cuil')?.validate('20-12345678-6')).toBe(true);
  });

  it('returns null for unknown document types', () => {
    expect(getValidator('CL', 'UNKNOWN')).toBeNull();
    expect(getValidator('XX', 'RUT')).toBeNull();
  });
});

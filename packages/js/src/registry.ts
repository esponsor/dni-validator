import { rutFormat, rutValidate } from './chile/rut.js';
import { curpFormat, curpValidate } from './mexico/curp.js';

export type ValidatorHandler = {
  validate: (value: string) => boolean;
  format?: (value: string) => string;
};

const registry: Record<string, Record<string, ValidatorHandler>> = {
  CL: {
    RUT: { validate: rutValidate, format: rutFormat },
  },
  MX: {
    CURP: { validate: curpValidate, format: curpFormat },
  },
};

export function getValidator(country: string, type: string): ValidatorHandler | null {
  return registry[country.toUpperCase()]?.[type] ?? null;
}

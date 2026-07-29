const DNI_PATTERN = /^\d{8}[\dA-K]?$/;

export function dniPeruClean(value: string): string {
  return value.toUpperCase().replace(/[^\dA-K]/g, '');
}

export function dniPeruFormat(value: string): string {
  return dniPeruClean(value).replace(/^(\d{8})([\dA-K])$/, '$1-$2');
}

/**
 * Structural check only: eight digits plus an optional verification character (0-9 or A-K).
 */
export function dniPeruValidate(value: string): boolean {
  return DNI_PATTERN.test(dniPeruClean(value));
}

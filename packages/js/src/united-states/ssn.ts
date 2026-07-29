const SSN_PATTERN = /^(?!666|000|9\d{2})\d{3}(?!00)\d{2}(?!0{4})\d{4}$/;

export function ssnUnitedStatesClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function ssnUnitedStatesFormat(value: string): string {
  return ssnUnitedStatesClean(value).replace(/^(\d{3})(\d{2})(\d{4})$/, '$1-$2-$3');
}

/**
 * Structural check only: rejects area, group and serial ranges the SSA never issues.
 */
export function ssnUnitedStatesValidate(value: string): boolean {
  return SSN_PATTERN.test(ssnUnitedStatesClean(value));
}

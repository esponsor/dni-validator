/**
 * Length check only: passport numbers have no verifiable structure.
 */
export function passportColombiaValidate(value: string): boolean {
  return value.length > 1 && value.length <= 12;
}

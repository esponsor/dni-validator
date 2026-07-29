/**
 * Length check only: passport numbers have no verifiable structure.
 */
export function passportEcuadorValidate(value: string): boolean {
  return value.length >= 8 && value.length <= 12;
}

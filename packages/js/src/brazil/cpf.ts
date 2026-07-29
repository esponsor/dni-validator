const REPEATED_DIGITS = /^(\d)\1+$/;

export function cpfClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function cpfFormat(value: string): string {
  return cpfClean(value).replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
}

export function cpfCheckDigit(base: string): number {
  const modulus = base.length + 1;
  let sum = 0;

  for (let i = 0; i < base.length; i++) {
    sum += Number(base[i]) * (modulus - i);
  }

  const remainder = sum % 11;

  return remainder < 2 ? 0 : 11 - remainder;
}

export function cpfValidate(value: string): boolean {
  const cpf = cpfClean(value);

  if (cpf.length !== 11 || REPEATED_DIGITS.test(cpf)) {
    return false;
  }

  let base = cpf.slice(0, 9);
  base += cpfCheckDigit(base);
  base += cpfCheckDigit(base);

  return base.slice(-2) === cpf.slice(-2);
}

const REPEATED_DIGITS = /^(\d)\1+$/;

export function cnpjClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function cnpjFormat(value: string): string {
  return cnpjClean(value).replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
}

export function cnpjCheckDigit(base: string): number {
  let weight = 2;
  let sum = 0;

  for (let i = base.length - 1; i >= 0; i--) {
    sum += Number(base[i]) * weight;
    weight = weight === 9 ? 2 : weight + 1;
  }

  const remainder = sum % 11;

  return remainder < 2 ? 0 : 11 - remainder;
}

export function cnpjValidate(value: string): boolean {
  const cnpj = cnpjClean(value);

  if (cnpj.length !== 14 || REPEATED_DIGITS.test(cnpj)) {
    return false;
  }

  let base = cnpj.slice(0, 12);
  base += cnpjCheckDigit(base);
  base += cnpjCheckDigit(base);

  return base.slice(-2) === cnpj.slice(-2);
}

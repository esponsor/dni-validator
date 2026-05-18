const CHARLIST = '0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';

const INCONVENIENT_WORDS = new Set([
  'BACA', 'BAKA', 'BUEI', 'BUEY', 'CACA', 'CACO', 'CAGA', 'CAGO', 'CAKA', 'CAKO',
  'COGE', 'COGI', 'COJA', 'COJE', 'COJI', 'COJO', 'COLA', 'CULO', 'FALO', 'FETO',
  'GETA', 'GUEI', 'GUEY', 'JETA', 'JOTO', 'KACA', 'KACO', 'KAGA', 'KAGO', 'KAKA',
  'KAKO', 'KOGE', 'KOGI', 'KOJA', 'KOJE', 'KOJI', 'KOJO', 'KOLA', 'KULO', 'LILO',
  'LOCA', 'LOCO', 'LOKA', 'LOKO', 'MAME', 'MAMO', 'MEAR', 'MEAS', 'MEON', 'MIAR',
  'MION', 'MOCO', 'MOKO', 'MULA', 'MULO', 'NACA', 'NACO', 'PEDA', 'PEDO', 'PENE',
  'PIPI', 'PITO', 'POPO', 'PUTA', 'PUTO', 'QULO', 'RATA', 'ROBA', 'ROBE', 'ROBO',
  'RUIN', 'SENO', 'TETA', 'VACA', 'VAGA', 'VAGO', 'VAKA', 'VUEI', 'VUEY', 'WUEI',
  'WUEY',
]);

const CURP_PATTERN = /^[A-Z]{4}[0-9]{6}(H|M)[A-Z]{5}[A-Z0-9][0-9]$/;

export function curpClean(value: string): string {
  return value.toUpperCase().replace(/[^\dA-Z]/g, '');
}

export function curpFormat(value: string): string {
  return curpClean(value);
}

export function curpCheckDigit(curp: string): number {
  const normalized = curp.toUpperCase().replace(/[^a-zA-Z0-9]/g, '');
  let sum = 0;

  for (let i = 0; i < 17; i++) {
    const position = CHARLIST.indexOf(normalized[i]);

    if (position === -1) {
      return -1;
    }

    sum += position * (18 - i);
  }

  const digit = 10 - (sum % 10);

  return digit === 10 ? 0 : digit;
}

export function curpValidate(value: string): boolean {
  const curp = value.toUpperCase().replace(/[^a-zA-Z0-9]/g, '');

  if (!CURP_PATTERN.test(curp)) {
    return false;
  }

  if (INCONVENIENT_WORDS.has(curp.slice(0, 4))) {
    return false;
  }

  const expected = curpCheckDigit(curp);

  if (expected === -1) {
    return false;
  }

  return String(expected) === curp[17];
}

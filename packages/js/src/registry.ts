import { cuitCuilFormat, cuitCuilValidate } from './argentina/cuit-cuil.js';
import { cnpjFormat, cnpjValidate } from './brazil/cnpj.js';
import { cpfFormat, cpfValidate } from './brazil/cpf.js';
import { sinCanadaFormat, sinCanadaValidate } from './canada/sin.js';
import { rutFormat, rutValidate } from './chile/rut.js';
import { ccColombiaFormat, ccColombiaValidate } from './colombia/cc.js';
import { nitColombiaFormat, nitColombiaValidate } from './colombia/nit.js';
import { passportColombiaValidate } from './colombia/passport.js';
import { ciEcuadorFormat, ciEcuadorValidate } from './ecuador/ci.js';
import { passportEcuadorValidate } from './ecuador/passport.js';
import { rutEcuadorValidate } from './ecuador/rut.js';
import { curpFormat, curpValidate } from './mexico/curp.js';
import { dniPeruFormat, dniPeruValidate } from './peru/dni.js';
import { rucPeruFormat, rucPeruValidate } from './peru/ruc.js';
import { dniSpainFormat, dniSpainValidate } from './spain/dni.js';
import { ssnUnitedStatesFormat, ssnUnitedStatesValidate } from './united-states/ssn.js';
import { ciUruguayFormat, ciUruguayValidate } from './uruguay/ci.js';
import { rutUruguayFormat, rutUruguayValidate } from './uruguay/rut.js';

export type ValidatorHandler = {
  validate: (value: string) => boolean;
  format?: (value: string) => string;
};

const ssnUnitedStates: ValidatorHandler = {
  validate: ssnUnitedStatesValidate,
  format: ssnUnitedStatesFormat,
};

const registry: Record<string, Record<string, ValidatorHandler>> = {
  AR: {
    'CUIT/CUIL': { validate: cuitCuilValidate, format: cuitCuilFormat },
  },
  BR: {
    CPF: { validate: cpfValidate, format: cpfFormat },
    CNPJ: { validate: cnpjValidate, format: cnpjFormat },
  },
  CA: {
    SIN: { validate: sinCanadaValidate, format: sinCanadaFormat },
  },
  CL: {
    RUT: { validate: rutValidate, format: rutFormat },
  },
  CO: {
    CC: { validate: ccColombiaValidate, format: ccColombiaFormat },
    NIT: { validate: nitColombiaValidate, format: nitColombiaFormat },
    PASS: { validate: passportColombiaValidate },
  },
  EC: {
    CI: { validate: ciEcuadorValidate, format: ciEcuadorFormat },
    RUT: { validate: rutEcuadorValidate },
    PASS: { validate: passportEcuadorValidate },
  },
  ES: {
    DNI: { validate: dniSpainValidate, format: dniSpainFormat },
  },
  MX: {
    CURP: { validate: curpValidate, format: curpFormat },
  },
  PE: {
    DNI: { validate: dniPeruValidate, format: dniPeruFormat },
    RUC: { validate: rucPeruValidate, format: rucPeruFormat },
  },
  PR: {
    SSN: ssnUnitedStates,
  },
  US: {
    SSN: ssnUnitedStates,
  },
  UY: {
    CI: { validate: ciUruguayValidate, format: ciUruguayFormat },
    RUT: { validate: rutUruguayValidate, format: rutUruguayFormat },
  },
};

export function getValidator(country: string, type: string): ValidatorHandler | null {
  return registry[country.toUpperCase()]?.[type.toUpperCase()] ?? null;
}

<?php

use Esponsor\DniValidator\Rules\RutChileRule;

it('passes validation for a valid RUT', function () {
    $rule = new RutChileRule();
    $failed = false;

    $rule->validate('rut', '11.111.111-1', function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeFalse();
});

it('fails validation for an invalid RUT', function () {
    $rule = new RutChileRule();
    $failed = false;

    $rule->validate('rut', '11.111.111-2', function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeTrue();
});

it('fails validation for non-string values', function () {
    $rule = new RutChileRule();
    $failed = false;

    $rule->validate('rut', 111111111, function () use (&$failed) {
        $failed = true;
    });

    expect($failed)->toBeTrue();
});

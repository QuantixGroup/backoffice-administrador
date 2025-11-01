<?php

use App\Models\Socio;

test('model Socio con tabla y atributos fillable esperados', function () {
    $model = new Socio;

    expect($model->getTable())->toBe('socios');

    $fillable = $model->getFillable();
    expect($fillable)->toContain('cedula')
        ->and($fillable)->toContain('nombre')
        ->and($fillable)->toContain('estado');
});

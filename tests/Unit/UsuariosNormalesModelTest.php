<?php

use App\Models\UsuariosNormales;

test('model UsuariosNormales con tabla y atributos fillable esperados', function () {
    $model = new UsuariosNormales;

    expect($model->getTable())->toBe('users');

    $fillable = $model->getFillable();
    expect($fillable)->toContain('cedula')
        ->and($fillable)->toContain('email');
});

<?php

use App\Models\User;

test('model User con tabla y atributos fillable esperados', function () {
    $model = new User();

    expect($model->getTable())->toBe('admins');

    $fillable = $model->getFillable();
    expect($fillable)->toContain('name')
        ->and($fillable)->toContain('cedula')
        ->and($fillable)->toContain('email');
});

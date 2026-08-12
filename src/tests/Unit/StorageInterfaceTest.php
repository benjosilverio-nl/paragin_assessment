<?php

use App\Storage\StorageInterface;

test('storage interface exists', function () {
    expect(interface_exists(StorageInterface::class))->toBeTrue();
});
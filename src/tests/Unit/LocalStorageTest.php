<?php

use App\Storage\LocalStorage;
use App\Storage\StorageInterface;

test('local storage class exists', function () {
    expect(class_exists(LocalStorage::class))->toBeTrue();
});

test('local storage implements storage interface', function () {
    expect(is_subclass_of(LocalStorage::class, StorageInterface::class))->toBeTrue();
});
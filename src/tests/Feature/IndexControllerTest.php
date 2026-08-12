<?php

test('index route returns a successful response', function () {
    $client = static::createClient();
    $client->request('GET', '/');

    expect($client->getResponse()->isSuccessful())->toBeTrue();
});

test('index route returns an html response', function () {
    $client = static::createClient();
    $client->request('GET', '/');

    expect($client->getResponse()->headers->get('content-type'))
        ->toContain('text/html');
});
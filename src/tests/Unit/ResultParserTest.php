<?php

use App\Parser\CsvParser;
use App\Parser\ResultParser;
use App\Parser\XlsxParser;

test('result parser interface exists', function () {
    expect(interface_exists(ResultParser::class))->toBeTrue();
});

test('result parser interface defines parse method', function () {
    expect(interface_exists(ResultParser::class))->toBeTrue();

    $reflection = new ReflectionClass(ResultParser::class);
    expect($reflection->hasMethod('parse'))->toBeTrue();
});

test('result parser parse method accepts a string file path', function () {
    expect(interface_exists(ResultParser::class))->toBeTrue();

    $method = new ReflectionMethod(ResultParser::class, 'parse');
    $parameters = $method->getParameters();

    expect(count($parameters))->toBe(1);
    expect($parameters[0]->hasType())->toBeTrue();
    expect((string) $parameters[0]->getType())->toBe('string');
});

test('csv parser class exists', function () {
    expect(class_exists(CsvParser::class))->toBeTrue();
});

test('xlsx parser class exists', function () {
    expect(class_exists(XlsxParser::class))->toBeTrue();
});

test('csv parser implements result parser', function () {
    expect(is_subclass_of(CsvParser::class, ResultParser::class))->toBeTrue();
});

test('xlsx parser implements result parser', function () {
    expect(is_subclass_of(XlsxParser::class, ResultParser::class))->toBeTrue();
});

test('csv parser defines parse method', function () {
    expect(method_exists(CsvParser::class, 'parse'))->toBeTrue();
});

test('csv parser parse method accepts a string file path', function () {
    expect(class_exists(CsvParser::class))->toBeTrue();

    $method = new ReflectionMethod(CsvParser::class, 'parse');
    $parameters = $method->getParameters();

    expect(count($parameters))->toBe(1);
    expect($parameters[0]->hasType())->toBeTrue();
    expect((string) $parameters[0]->getType())->toBe('string');
});

test('xlsx parser defines parse method', function () {
    expect(method_exists(XlsxParser::class, 'parse'))->toBeTrue();
});

test('xlsx parser parse method accepts a string file path', function () {
    expect(class_exists(XlsxParser::class))->toBeTrue();

    $method = new ReflectionMethod(XlsxParser::class, 'parse');
    $parameters = $method->getParameters();

    expect(count($parameters))->toBe(1);
    expect($parameters[0]->hasType())->toBeTrue();
    expect((string) $parameters[0]->getType())->toBe('string');
});
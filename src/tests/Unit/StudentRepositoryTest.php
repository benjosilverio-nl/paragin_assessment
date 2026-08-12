<?php

use App\Repository\JsonStudentRepository;
use App\Repository\StudentRepositoryInterface;

test('student repository interface exists', function () {
    expect(interface_exists(StudentRepositoryInterface::class))->toBeTrue();
});

test('json student repository class exists', function () {
    expect(class_exists(JsonStudentRepository::class))->toBeTrue();
});

test('json student repository implements student repository interface', function () {
    expect(is_subclass_of(JsonStudentRepository::class, StudentRepositoryInterface::class))->toBeTrue();
});

test('json student repository implements all student repository contract methods', function () {
    expect(interface_exists(StudentRepositoryInterface::class))->toBeTrue();
    expect(class_exists(JsonStudentRepository::class))->toBeTrue();

    $interfaceReflection = new ReflectionClass(StudentRepositoryInterface::class);
    $classReflection = new ReflectionClass(JsonStudentRepository::class);

    foreach ($interfaceReflection->getMethods() as $method) {
        expect($classReflection->hasMethod($method->getName()))->toBeTrue();

        $classMethod = $classReflection->getMethod($method->getName());
        expect($classMethod->isPublic())->toBeTrue();
    }
});

test('adds a student to the JSON file', function () {
    $file = tempFile('students.json');
    $repo = new JsonStudentRepository($file);

    $repo->update([[
        'student_id' => 'Student 101',
        'scores' => [],
        'performance' => []
    ]]);

    $data = json_decode(file_get_contents($file), true);

    expect($data)->toHaveCount(1);
    expect($data[0]['student_id'])->toBe('Student 101');
});

test('retrieves a student by ID', function () {
    $file = tempFile('students.json');
    $repo = new JsonStudentRepository($file);

    $repo->update([[
        'student_id' => 'Student 101',
        'scores' => [],
        'performance' => []
    ]]);

    $student = $repo->getStudent('Student 101');

    expect($student)->not->toBeNull();
    expect($student['student_id'])->toBe('Student 101');
});

test('returns null when student does not exist', function () {
    $file = tempFile('students.json');
    $repo = new JsonStudentRepository($file);

    $student = $repo->getStudent('Unknown');

    expect($student)->toBeNull();
});

test('returns all students', function () {
    $file = tempFile('students.json');
    $repo = new JsonStudentRepository($file);

    $repo->update([[
        'student_id' => 'Student 101',
        'scores' => [],
        'performance' => []
    ],
    [
        'student_id' => 'Student 102',
        'scores' => [],
        'performance' => []
    ]]);

    $students = $repo->getAll();

    expect($students)->toHaveCount(2);
    expect($students[0]['student_id'])->toBe('Student 101');
    expect($students[1]['student_id'])->toBe('Student 102');
});

test('creates the JSON file automatically when missing', function () {
    $file = tempFile('students.json');

    // Ensure file does not exist
    if (file_exists($file)) unlink($file);

    $repo = new JsonStudentRepository($file);

    $repo->update([[
        'student_id' => 'Student 101',
        'scores' => [],
        'performance' => []
    ]]);

    expect(file_exists($file))->toBeTrue();
});





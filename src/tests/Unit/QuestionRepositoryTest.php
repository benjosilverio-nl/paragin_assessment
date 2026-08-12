<?php

use App\Repository\JsonQuestionRepository;
use App\Repository\QuestionRepositoryInterface;


test('question repository interface exists', function () {
    expect(interface_exists(QuestionRepositoryInterface::class))->toBeTrue();
});

test('json question repository class exists', function () {
    expect(class_exists(JsonQuestionRepository::class))->toBeTrue();
});

test('json question repository implements question repository interface', function () {
    expect(is_subclass_of(JsonQuestionRepository::class, QuestionRepositoryInterface::class))->toBeTrue();
});

test('json question repository implements all question repository contract methods', function () {
    expect(interface_exists(QuestionRepositoryInterface::class))->toBeTrue();
    expect(class_exists(JsonQuestionRepository::class))->toBeTrue();

    $interfaceReflection = new ReflectionClass(QuestionRepositoryInterface::class);
    $classReflection = new ReflectionClass(JsonQuestionRepository::class);

    foreach ($interfaceReflection->getMethods() as $method) {
        expect($classReflection->hasMethod($method->getName()))->toBeTrue();

        $classMethod = $classReflection->getMethod($method->getName());
        expect($classMethod->isPublic())->toBeTrue();
    }
});

test('returns all questions', function () {
    $file = tempFile('questions.json');
    $repo = new JsonQuestionRepository($file);

    $repo->update([['id' => 1, 'title' => 'Q1', 'max_score' => 5],['id' => 2, 'title' => 'Q2', 'max_score' => 5]]);

    $questions = $repo->getAll();

    expect($questions)->toHaveCount(2);
    expect($questions[0]['id'])->toBe(1);
    expect($questions[1]['id'])->toBe(2);
});

test('finds a question by ID', function () {
    $file = tempFile('questions.json');
    $repo = new JsonQuestionRepository($file);

    $repo->update([['id' => 1, 'title' => 'Q1', 'max_score' => 5],['id' => 2, 'title' => 'Q2', 'max_score' => 5]]);

    $question = $repo->findQuestionById(2);

    expect($question)->not->toBeNull();
    expect($question['title'])->toBe('Q2');
});

test('returns null when question does not exist', function () {
    $file = tempFile('questions.json');
    $repo = new JsonQuestionRepository($file);

    $repo->update([['id' => 1, 'title' => 'Q1', 'max_score' => 5]]);

    $question = $repo->findQuestionById(999);

    expect($question)->toBeNull();
});

test('creates the JSON file automatically when missing', function () {
    $file = tempFile('questions.json');

    if (file_exists($file)) unlink($file);

    $repo = new JsonQuestionRepository($file);

    $repo->update([['id' => 1, 'title' => 'Q1', 'max_score' => 5]]);

    expect(file_exists($file))->toBeTrue();
});

test('maintains correct JSON structure after multiple operations', function () {
    $file = tempFile('questions.json');
    $repo = new JsonQuestionRepository($file);

    $repo->update([['id' => 1, 'title' => 'Q1', 'max_score' => 5],['id' => 2, 'title' => 'Q2', 'max_score' => 5],['id' => 3, 'title' => 'Q3', 'max_score' => 5]]);

    $data = json_decode(file_get_contents($file), true);

    expect($data)->toHaveCount(3);
    expect($data[2]['title'])->toBe('Q3');
});





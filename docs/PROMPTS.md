# Prompt Log

## 2026-08-10

### Prompt 1

I'm creating a new project.

* I need all my prompts logged under docs/PROMPTS.md, including this prompt
* Project Brief can be found on Backend "docs/Developer Assignment.md"
* Start scanning the project brief for background on what I'll be doing.
* Also scan xlsx file in results/, we'll be referencing this for the data processing capability of the application I'll be building.

### Prompt 2

I need background explanation on what standard psychometric values is.

### Prompt 3

In  this ceasura,  can you help me interpret it, it looks like it only provides 3 grades, 1.0, 5.5, and 10.0, am I wrong?

- The grade ranges between 1.0 and 10.0, expressed to one decimal place
	- When a student scores 20% (or less) of the available points, they receive a 1.0
	- When a student scores 70% of the available points, they receive a 5.5 and pass the exam
	- When a student scores 100% of the available points, they receive a 10.0

### Prompt 4

The markdown for the assignment shows formula for the assesment of the results, these formulas output raw numbers, can you help me check if I missed how these numbers are interpreted?

### Prompt 5

I've created a REFINEMENT.md, check it if there's any further clarfications we need to be able to cover the assignment?

### Prompt 6

I've reverted the REFINEMENT.md adjustments, most of those are already covered by the initial, and some are quite clear from the Backend Developer Assignment.md

### Prompt 7

Can you update our markdown files, so all prompts for this project will be logged under docs/PROMPTS.md, some of the prompts is missing in the logs.

### Prompt 8

We need a config markdown for the ide-agent so that all prompts are automatically logged without me asking

### Prompt 9

Can you check if all our future prompts will be logged under docs/PROMPTS.md based on copilot-instructions.md?

## 2026-08-11

### Prompt 10

I'll start setting up my project framework now.
*  Initialize a symfony microframework for me with the latest version
*  Create an initial test for IndexController, don't create the controller yet, I'll utilize TDD with failing test cases
*  Include pest testing framework on the setup
*  place the setup under /src

### Prompt 11

I'm starting of with entry point of the application.
* Entry point will be IndexController, generate this for me with, I've updated the composer to have twig templating engine, generate an empty index.html.twig.
* Update our test cases as necessary.
* Let's create a docs/features directory for feature markdowns
* And update features markdown with LandingPage/SPECS.md
	* IndexController as the entry point for landing page, and it will render index.html.twig, also update the corresponding test cases on this markdown with the information on the tests that we have for our IndexController

### Prompt 12

Let's start creating the background services for uploading and storing of our test results files.
* Let's create first a test for existence of a file upload service [FileUploadService]
* Create a markdown for features/ "FileUpload", and place this test for the service

### Prompt 13

Generate a FileUploadService class for me.  Just add a contstructor, handle(), and generateFilename() methods, leave it empty

### Prompt 14

Generate these interface and class existence tests for me.
* StorageInterface
* LocalStorage class that implements StorageInterface

Don't create the class files yet, just the tests.  Also, update our FileUpload features markdown for these tests

### Prompt 15

Map my implementation of FileUploadService
* Generate the StorageInterface & LocalStorage interface, check my implementation for the pattern.
* Update our markdown features as necessary.

### Prompt 16

Are there possible strategy design pattern implementation for my upload service?  given the project brief at hand, I'm thinking we would have different validation conditions, and filetype checking.  I'm thinking we just validate for CSV & xlsx, and then just strategize the validator.

### Prompt 17

Let's update our test cases for file upload.
*  FileUploadService can
	* Receive a file and store locally
	* Validate against CSV/XLSX (reference my file_upload.yaml)
	* And validate against max size I set on file_upload.yaml per file type

Also update our markdowns for these details.

### Prompt 18

We've got the failing tests for the file upload with validators and max file sizes.

Let's start implementing validators for the file upload.

I'll be needing for you to generate:

ValidatorStrategy interface
	* Contains validate($file, $maxSize)

ValidatorStrategy implementations: CsvValidator & XlsxValidator
	* validates against the $file's max size with the $maxSize param
	* throwing new RuntimeException for each failures

ValidatorContext class - this will run the validators depending on the configurations we have under the parameters: of file_upload.yml
	* constructor with private $config, and private iterable $strategies
	* validate() method with the $file as the parameter
	* Iteration through the config to match the file uploaded with each mime type and implement the proper strategy depending on the matching configuration.
	* throw new RuntimeException if no match for any of the mime type we have on the configuration.

### Prompt 19

Let's move the validate() call to the resolved strategy.

### Prompt 20

I've updated the signature of the FileUploadService constructor, I need adjustments for our tests

### Prompt 21

Let's make sure all our markdowns are updated based on the modifications I did on the interface and services signatures

### Prompt 22

I'm moving to the next feature, ResultParser, let's start with creating test for these.  Start off first with existence tests.
*  Test for existence of ReasultParser interface
*  Existence of two implementations of the ResultParser, CsvParser and XlsxParser
*  Let's also add to the test the parse() method as contract for the interface, and implementation in the CswvParser and XlsxParser

Update our markdowns, under features/ResultParser

### Prompt 23

Let's also add tests for the  parse() method, should be accepting string for the file's path to parse

### Prompt 24

I'll be needing the repository classes and interface inside the parser service. 

Create tests for repository class existence
*  ResultRepository interface
*  ResultJsonRepository class the implements the ResultRepository

Test for the following:
*  interface and classes existence
* implementing classes implements the contract methods

### Prompt 25

Let's adjust, the repositor tests...

We'll implement two interfaces:
* StudentRepositoryInterface & QuestionRepositoryInterface
* Implemented by JsonStudentInterface & JsonQuestionInterface
* Same initial test logic, class and interface existence, and implementations implementing contract methods test

### Prompt 26

Let's separate the two tests.. StudentRepositoryTest.php for student test concerns, and QuestionRepositoryTest.php for questions

### Prompt 27

Let's sync our markdown docs with the code we actually implemented.

* Repository classes and interfaces were added and need to be documented.
* The grading config and package configuration were not reflected in the markdowns.
* The dependency injection wiring in `src/config/services.yaml` and `src/config/packages/grading.yaml` also needs to be captured.
* Review the implementation and update the feature docs so the markdown matches the code in the project.
* Add any remaining notes that explain how the upload, repository, parser, and grading layers fit together.

This sync pass updates the documentation to match the implemented repository layer, custom grading configuration, and DI wiring without changing the Symfony framework files themselves.

### IDE Agent stopped logging prompts, missed track of the rest of the prompts
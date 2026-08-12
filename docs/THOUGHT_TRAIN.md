10/08/2026
20:15  Skim through the Backend Developer Assignment.md to get through the general idea on what has to be done, and send confirmation to Jan on the estimate.

## Started with the assignment.
20:45  Thoroughly read through the markdown on the detailed information of the task in hand.
21:06  Should I be sending the refinement questions for PO and assesment expert to Jan to get further details on how the code output be?
21:08  I need to start breaking down the requirements to build the refinement question.
21:13  I have to read on standard psychometric values & caesura.
21:20  I have to figure out how to interpret the number output from the formula to determine evaluation based on the raw numbers.
21:40  Finishied refinement questions.
## Paused for the evening.

##  Started setup of framework (started during shift break)
10:30 Initialize symfony microframework with pest using IDE agent with initial controller test for IndexController.
10:33 Initialize docker dev environment (I have existing I reused).
## Pause for shift continuation

## Started a few things again during another shift break
14:35 Create failing test for the landing page controller, and make it pass by building the controller.
15:00 Create failing test for FileUpload feature (Upload service, storage, service, validation, and validation strategies)
15:10 Make all test pass.
## Pause for shift continuation -  will continue in the evening for the data assessment

## Started on parsing of uploaded files 21:00 (11/08) to 01:00 (12/08)
I need to start the parser classes, start off with the ResultParser that will be implemented by classes for parsing CSV and Xlsx, kick it off by creating tests for existence validation.
Then build the parser service.
I'll have to create the repository for storage this early in the development of parser classes, insertion of rows to data store should happen line by line to avoid memory exhaustion.
The single ResultRepository needed to be split between Students and Questions to ensure domain separation and decoupling
Extract the whole sheet into a structured data storage, and validate the data from there to not interfere with the parsing.
Start analyzing the data through a analysis service
Since the caesura need might be different for exams, since we don't have a system backend, it at least to be configurable on the application's configuration file for the anchors of the grades
Start testing the flow now on the UI and render the tests & analysis results
Create at least a presentable presentation of the data for the user.


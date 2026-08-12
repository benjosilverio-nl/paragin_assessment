# Assessment "Backend developer at Paragin"

## Introduction

At Paragin, we build various complex Software as a Service (SaaS) products for education and career management. In several of our products, students take their exams online. Every time a student does so, we collect a large amount of result data that has to be processed and analysed afterwards: to tell the student how they did, and to tell the tutor how their questions performed.

Processing and analysing results is one of the core responsibilities of our backend. It has to be correct, it has to be explainable to customers, and it has to work for many different exams with many different rules.

For this assessment, we ask you to implement a small part of that: calculating grades and reporting on the quality of the questions. This assessment lets us see how you would approach a task that could also very well be part of your job.

## Functional description

You are given an Excel sheet with the results of a group of students from a real exam, sent to you together with this assignment. Your job is to calculate the grade for each student, decide whether they passed, and report the quality of each question using standard psychometric values.

### Calculating the grade

The grade for an exam is calculated using so-called 'grading boundary', also known as a 'caesura'. The caesura defines how a score is translated into a grade, and when a grade counts as 'passed' or 'failed'.

The caesura for this specific exam is defined as follows:

  - The grade ranges between 1.0 and 10.0, expressed to one decimal place
  - When a student scores 20% (or less) of the available points, they receive a 1.0
  - When a student scores 70% of the available points, they receive a 5.5 and pass the exam
  - When a student scores 100% of the available points, they receive a 10.0

Note that other exams might use another caesura with different percentages.

### Analytics

After the grades are calculated, the tutor wants to know how their questions turned out. Are there any questions that were too easy or too difficult?

Two useful statistics are the $P'$-value and the $r_{it}$-value. The tutor preferably wants to know both values, so they can adjust the exam for next year's batch of students.

#### $P'$-value

The $P'$-value is a very basic statistic. It ranges between 0 and 1 and is the quotient of the average score of all candidates on the given question and the maximum score of that question.

In other words, the $P'$-value for question _i_ is calculated as follows:

$$ P'_{i} = \frac{S_{avg_i}}{S_{max_i}} $$

#### $r_{it}$-value

The $r_{it}$-value of a question is a little bit more complicated. $r_{it}$ is the correlation coefficient (also denoted as _r_) between the scores obtained on the question (denoted as _i_ from 'item') and the result on the test (denoted as _t_).

A correlation ranges between $-1$ and $+1$ and tells the tutor how well a question distinguishes between strong and weak candidates. A high $r_{it}$-value means that students who did well on the exam as a whole also did well on this question. A value around zero means the question says little about the overall ability of a candidate. A negative value means that weaker students outscored stronger ones on this question, which is usually a signal that something is wrong with the question itself.

In Excel, a correlation coefficient can easily be calculated using the `CORREL` function, but in most programming languages no such function exists out of the box. For more information on how to calculate a correlation coefficient, you can refer to (for example) [Wikipedia][1].

## The assessment

This assessment has two parts. Part 1 is a short written exercise about how you would help prepare this functionality before any code is written. Part 2 is a practical build.

### Part 1: Refinement questions

Imagine you are in a refinement session for this functionality together with a product owner and an assessment expert. You have this brief in front of you, the way you would when work is prepared for development.

The product owner knows what the product needs and what our customers ask for. The assessment expert knows all about caesuras and psychometric analytics: why these statistics matter to a tutor, and why a grade is calculated the way it is.

Your job here is not to repeat what the brief already tells you, but to find what it does not. Surface the gaps, ambiguities, and dependencies you would want resolved before a line of code is written.

Write down the questions you would ask, grouped by who you would ask them to:

  - Questions for the product owner
  - Questions for the assessment expert

There is no single correct set of questions. We are interested in how critically you read a brief and how you think about what is missing. A short written list is enough; you do not need to answer your own questions. This part should not take long.

You can include this as a separate file (for example `REFINEMENT.md`) in the same repository or zip as your code, or in your accompanying e-mail.

### Part 2: Building the tool

Build a tool that reads the provided Excel sheet, calculates the grade and pass/fail result for every student, and reports the $P'$-value and $r_{it}$-value for every question.

#### Goals and directions

The goal of this part is not only to determine your programming and problem-solving skills, but also to see how you structure your code. We are not looking for the perfect solution, or one that could be dropped into our products as-is. We want to see how you would tackle a task like this in a real situation, with the same time constraints and knowledge gaps you would have on the job.

A few directions:

  - Write your solution in PHP. That is the language our backend is built in.
  - Presentation of the resulting data is not the most important part of this assessment. We prefer accuracy.
  - You do not have to write all the code yourself. If you know a good external library that solves part of this assignment, you are free to use it, as long as you keep it separate from your own code. Using Composer is encouraged.
  - The code should represent who you are as a developer and how you work in real life. It should show us what you bring to the team, so use the patterns and styles you would also use for production-worthy code.
  - Think about how your solution can be used for other exams, other caesuras, and other Excel sheets as well.

You are encouraged to use coding agents such as Claude Code, Cursor, or OpenAI Codex. We use them in our own workflow and are genuinely interested in how you work with one. Whether or not you use an agent, the decisions and the result are yours: you still direct the work, and we look at the choices you make, how you steer the tool, and how you review what it produces. If you do use an agent, please include the prompts you gave it, and a transcript of the session if your tool can export one. A best-effort export is fine, and the prompts alone are the minimum.

If you use an agent and find yourself with time left, we would like to challenge you to extend your submission: improve the presentation of the results, the quality assurance around your code, or the functionality of the tool.

#### Keeping a log

This is not mandatory, but we would really appreciate a small timeline in a text file that shows the train of thought you followed while building. Keep it light, so it does not distract from the assignment itself.

## Practical matters

Keep track of the time you spend on this assignment and plan well ahead. We think this assignment could be done in four hours and we urge you to not spend much more than that. We would rather see a smaller, well-structured result than an exhausted attempt at everything, so build a solid core first and use placeholders for the rest.

You can deliver the result in any way you see fit: a link to a public GitLab/GitHub repository or a zip file are both fine. Please include:

  - your refinement questions from Part 1, for example as a `REFINEMENT.md` file
  - the code for the tool from Part 2
  - if you used a coding agent, the prompts you gave it, plus a transcript of the session if you can export one
  - if you kept one, your log with the timeline of your train of thought

If you have any questions during the assessment, you are more than welcome to ask for information. You can send an e-mail to [j.kaper@paragin.com](mailto:j.kaper@paragin.com) or call +31 (0)6 - 461 353 78.

[1]: https://en.wikipedia.org/wiki/Pearson_correlation_coefficient
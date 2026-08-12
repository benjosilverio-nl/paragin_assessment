## PRODUCT OWNER
*  Do we expectations from tutors on what output they wanted to see?  I believe presentation is not the most important part of the output, but do we have preferences?
*  About how the users will interact with this tool, do we intend to have a pool of test results, that will be processed in the background on a queue, and a view for each file will be available for the results?  Or do we prefere the upload, real time processing and display results?
*  Is this spreadsheet on a standard format?  Do we need to create a logic that will adapt accordingly for different question count?
*  What tolerance level do we need for the processing? Do we show partial result when we hit a invalid data and just flag the invalid rows?
*  I see the caesura as a configuration for the caesura rules, do we need support ( do we see necessity ) for tutor's ability to add rules/new set of rules for dynamic update, creation of variants, or let the developer do the creation of additional rules? 
*  Same with the evaluation results, do we see value on having this configurable by users within the tool? Or let developers handle adjustments via quick configurations?
*  What's the delivery format of the tool?  I'm thinking this would be on a Web UI, but will we need support for CLI commands?

## ASSESSMENT EXPERT
*  For the ceasura, the ranges are clear for the rules on 20%, 70%, and 100%, but do we have a formula on figuring out the values in between?
*  Do we have preferences on the rules for rounding results?
*  This evaluation will be based on a group of data, which includes averaging, how do we treat missing or incomplete data?
*  These rules on the data interpretation provide formulas for data interpretation, that have numbers as results, do we guidance on how to provide interpretation for these values, or just output raw numbers, and tutors knows how to interpret these?
*  $P'$-value has proportion from 0 (closer to harder) to 1 (closer to harder), where's the line?
*  $r_{it}$-value positive or high means question has high correlation with students who did well, around 0 mean no correlation, and negative something wrong with the question.  Do we stick to this three analysis, or we need to present a better explanation?
*  Any suggestion how these assesments are presented well, wherein the tutors will be best to utilize the information and make use of it?
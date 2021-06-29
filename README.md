# ClassMarker.com
ClassMarker is a secure online Quiz Maker platform for Business and Education for giving exams and assessments.

## Developer Documentation
[https://www.classmarker.com/online-testing/docs/](https://www.classmarker.com/online-testing/docs/)

#### You can use the ClassMarker API to quickly integrate exams. You can perform operations such as:

- Retrieving exam results
- Controlling access to exams
- Adding and editing questions and question categories

## API Client example usage

```php
<?php
include("./ClassMarkerApiClient.php");
$api_key = 'YOUR_API_KEY_HERE';
$api_secret= 'YOUR_API_SECRET_HERE';



# Example 1. GET: Receive all Groups and Link Assignments
$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getAllGroupLinkTest();
echo $json_response;
exit;



# Example 2. GET: Receive recent results for all groups
$finishedAfterTimestamp = 1339777290;
$limit = 200;

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getRecentResultForAllGroups($finishedAfterTimestamp, $limit);
echo $json_response;
exit;




# Example 3. GET: Receive  recent results for all links
$finishedAfterTimestamp = 1339777290;
$limit = 200;

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getRecentResultsForAllLinks($finishedAfterTimestamp, $limit);
echo $json_response;
exit;



# Example 4. GET: Receive recent results for specific group/exam
$finishedAfterTimestamp = 1339777290;
$limit = 200;
$test_id = 726750;
$group_id = 151877;

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getRecentResultsForSingleGroup($test_id, $group_id, $finishedAfterTimestamp, $limit);
echo $json_response;
exit;



# Example 5. Get: Receive recent results for specific link/exam
$finishedAfterTimestamp = 1339777290;
$limit = 200;
$test_id = 293383;
$link_id = 332382;

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getRecentResultsForSingleLink($test_id, $group_id, $finishedAfterTimestamp, $limit);
echo $json_response;
exit;



# Example 6. POST: Add access codes
$access_list_id = 123456;
$json_body = '["Code1", "Code2", "Code3", "Code4"]';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->addAccessListCodes($access_list_id, $json_body);
echo $json_response;
exit;



# Example 7. DELETE: Remove access codes
$access_list_id = 123456;
$json_body = '["Code1", "Code2", "Code3", "Code4"]';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->deleteAccessListCodes($access_list_id, $json_body);
echo $json_response;
exit;



# Example 8. GET: Receive all categories
$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getAllCategories();
echo $json_response;
exit;



# Example 9. POST: Add new parent category
$parent_category_name = 'Mathematics';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->addParentCategory($parent_category_name);
echo $json_response;
exit;


# Example 10. PUT: Update a single parent category
$parent_category_id = 2;
$parent_category_name = 'Mathematics';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->updateParentCategory($parent_category_id, $parent_category_name);
echo $json_response;
exit;



# Example 11. POST: Add new category
$parent_category_id = 2;
$parent_category_name = 'Calculus';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->addCategory($parent_category_id, $category_name);
echo $json_response;
exit;



# Example 12. PUT: Update a single category
$parent_category_id = 2;
$category_id = 3;
$parent_category_name = 'Fractions';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->updateCategory($category_id, $parent_category_id, $category_name);
echo $json_response;
exit;



# Example 13. GET: Receive all questions
$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getAllQuestions();
echo $json_response;
exit;



# Example 14. GET: Receive a single question
$question_id = 53353203;

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->getQuestion($question_id);
echo $json_response;
exit;



# Example 15. POST: Add a new question
# See Question format Examples at: https://www.classmarker.com/online-testing/docs/api/#question-object-Examples
$question_json = '{
  "question": "What is the first step for treating a skin burn?",
  "question_type": "multiplechoice",
  "category_id": 3,
  "random_answers": false,
  "points": "2.0",
  "correct_feedback": "Well done!",
  "incorrect_feedback": "Sorry, that was incorrect, refer to your training materials for further details.",
  "options": {
    "A": {
      "content": "Apply oil or butter"
    },
    "B": {
      "content": "Nothing should be done"
    },
    "C": {
      "content": "Soak in water for five minutes"
    },
    "D": {
      "content": "Apply antibiotic ointment"
    }
  },
  "correct_options": ["C"]
}';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->addQuestion($question_json);
echo $json_response;
exit;



# Example 16. PUT: Update a single question
# See Question format Examples at: https://www.classmarker.com/online-testing/docs/api/#question-object-Examples
$question_id = 53353998;
$question_json = '{
  "question": "What is the first step for treating a skin burn?",
  "question_type": "multiplechoice",
  "category_id": 3,
  "random_answers": false,
  "points": "2.0",
  "correct_feedback": "Well done!",
  "incorrect_feedback": "Sorry, that was incorrect, refer to your training materials for further details.",
  "options": {
    "A": {
      "content": "Apply oil or butter"
    },
    "B": {
      "content": "Nothing should be done"
    },
    "C": {
      "content": "Soak in water for five minutes"
    },
    "D": {
      "content": "Apply antibiotic ointment"
    }
  },
  "correct_options": ["C"]
}';

$cm_client = new ClassMarkerClient($cm_api_key, $cm_api_secret);
$json_response = $cm_client->updateQuestion($question_id, $question_json);
echo $json_response;

```

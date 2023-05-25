<?php namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builderQuestions = $this->db->table('quiz_questions');
        $this->builderAnswers = $this->db->table('quiz_answers');
        $this->builderResults = $this->db->table('quiz_results');
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * QUESTION
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz questions
    public function addQuizQuestions($postId)
    {
        $questionTitles = inputPost('question_title');
        $questionImages = inputPost('question_image');
        $questionImageStorages = inputPost('question_image_storage');
        $questionDescriptions = inputPost('question_description');
        $questionOrders = inputPost('question_order');
        $answerFormats = inputPost('answer_format');
        $questionUniqueIds = inputPost('question_unique_id');
        if (!empty($questionTitles)) {
            for ($i = 0; $i < countItems($questionTitles); $i++) {
                $data = [
                    'post_id' => $postId,
                    'question' => !empty($questionTitles[$i]) ? $questionTitles[$i] : '',
                    'image_path' => !empty($questionImages[$i]) ? $questionImages[$i] : '',
                    'image_storage' => !empty($questionImageStorages[$i]) ? $questionImageStorages[$i] : '',
                    'description' => !empty($questionDescriptions[$i]) ? $questionDescriptions[$i] : '',
                    'question_order' => !empty($questionOrders[$i]) ? $questionOrders[$i] : '',
                    'answer_format' => !empty($answerFormats[$i]) ? $answerFormats[$i] : 'small_image'
                ];
                if ($this->builderQuestions->insert($data)) {
                    $lastId = $this->db->insertID();
                    $this->addQuizAnswers($postId, $lastId, @$questionUniqueIds[$i]);
                }
            }
        }
    }

    //add quiz question
    public function addQuizQuestion($postId)
    {
        $maxOrder = $this->getQuizQuestionMaxOrder($postId);
        if (empty($maxOrder)) {
            $maxOrder = 0;
        }
        $data = [
            'post_id' => $postId,
            'question' => '',
            'image_path' => '',
            'image_storage' => '',
            'description' => '',
            'question_order' => $maxOrder + 1,
            'answer_format' => 'small_image'
        ];
        if ($this->builderQuestions->insert($data)) {
            $lastId = $this->db->insertID();
            //add two answers
            $this->addQuizQuestionAnswer($lastId);
            $this->addQuizQuestionAnswer($lastId);
            return $lastId;
        }
        return false;
    }

    //update quiz questions
    public function editQuizQuestions($post)
    {
        if (!empty($post)) {
            if (!checkPostOwnership($post->user_id)) {
                return false;
            }
            $questions = $this->getQuizQuestions($post->id);
            if (!empty($questions)) {
                foreach ($questions as $question) {
                    $data = [
                        'question' => inputPost('question_title_' . $question->id),
                        'image_path' => inputPost('question_image_' . $question->id),
                        'image_storage' => inputPost('question_image_storage_' . $question->id),
                        'description' => inputPost('question_description_' . $question->id),
                        'question_order' => inputPost('question_order_' . $question->id),
                        'answer_format' => inputPost('answer_format_' . $question->id)
                    ];
                    $this->builderQuestions->where('id', $question->id)->update($data);
                    //update quiz answers
                    $this->editQuizAnswers($post, $question->id);
                }
            }
            //add new quiz questions
            $this->addQuizQuestions($post->id);
        }
    }

    //get quiz questions
    public function getQuizQuestions($postId)
    {
        return $this->builderQuestions->where('post_id', cleanNumber($postId))->orderBy('question_order')->get()->getResult();
    }

    //get quiz question
    public function getQuizQuestion($id)
    {
        return $this->builderQuestions->where('id', cleanNumber($id))->get()->getRow();
    }

    //get quiz question max order value
    public function getQuizQuestionMaxOrder($postId)
    {
        return $this->builderQuestions->select('MAX(question_order) AS max_order')->where('post_id', cleanNumber($postId))->get()->getRow()->max_order;
    }

    //delete quiz question
    public function deleteQuizQuestion($id)
    {
        $question = $this->getQuizQuestion($id);
        if (!empty($question)) {
            $this->deleteQuizQuestionAnswers($question->id);
            $this->builderQuestions->where('id', $question->id)->delete();
        }
    }

    //delete quiz questions
    public function deleteQuizQuestions($postId)
    {
        $questions = $this->getQuizQuestions($postId);
        if (!empty($questions)) {
            foreach ($questions as $question) {
                $this->deleteQuizQuestion($question->id);
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * ANSWER
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz answers
    public function addQuizAnswers($postId, $questionId, $questionElementId)
    {
        $post = getPostById($postId);
        if (!empty($post)) {
            if (!empty($questionId) && !empty($questionElementId)) {
                $answerTexts = inputPost('answer_text_question_' . $questionElementId);
                $answerImages = inputPost('answer_image_question_' . $questionElementId);
                $answerImageStorages = inputPost('answer_image_question_storage_' . $questionElementId);
                $answerUniqueIds = inputPost('answer_unique_id_question_' . $questionElementId);
                $resultOrders = inputPost('answer_selected_result_question_' . $questionElementId);
                $isCorrect = 0;
                $assignedResultId = 0;
                if (!empty($answerTexts)) {
                    for ($i = 0; $i < countItems($answerTexts); $i++) {
                        //find correct answer
                        if ($post->post_type == 'trivia_quiz') {
                            $selectedAnswer = inputPost('correct_answer_question_' . $questionElementId, true);
                            $isCorrect = !empty($answerUniqueIds[$i]) && ($answerUniqueIds[$i] == $selectedAnswer) ? 1 : 0;
                        }
                        //find selected result id
                        if ($post->post_type == 'personality_quiz') {
                            if (!empty($resultOrders[$i])) {
                                $result = $this->getQuizResultByOrderNumber($post->id, $resultOrders[$i]);
                                if (!empty($result)) {
                                    $assignedResultId = $result->id;
                                }
                            }
                        }
                        $data = [
                            'question_id' => $questionId,
                            'image_path' => !empty($answerImages[$i]) ? $answerImages[$i] : '',
                            'image_storage' => !empty($answerImageStorages[$i]) ? $answerImageStorages[$i] : '',
                            'answer_text' => !empty($answerTexts[$i]) ? $answerTexts[$i] : '',
                            'is_correct' => $isCorrect,
                            'assigned_result_id' => $assignedResultId
                        ];
                        $this->builderAnswers->insert($data);
                    }
                }
            }
        }
    }

    //add quiz question answer
    public function addQuizQuestionAnswer($questionId)
    {
        $data = [
            'question_id' => $questionId,
            'image_path' => '',
            'image_storage' => '',
            'answer_text' => '',
            'is_correct' => 0,
        ];
        if ($this->builderAnswers->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //edit quiz answers
    public function editQuizAnswers($post, $questionId)
    {
        if (!empty($post)) {
            if (!checkPostOwnership($post->user_id)) {
                return false;
            }
            $answers = $this->getQuizQuestionAnswers($questionId);
            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    $isCorrect = 0;
                    $assignedResultId = 0;
                    //find correct answer
                    if ($post->post_type == "trivia_quiz") {
                        $correctAnswerId = inputPost('correct_answer_q' . $questionId);
                        $isCorrect = !empty($correctAnswerId) && ($correctAnswerId == $answer->id) ? 1 : 0;
                    }
                    //find selected result id
                    if ($post->post_type == "personality_quiz") {
                        $resultOrder = inputPost('answer_selected_result_' . $answer->id);
                        $result = $this->getQuizResultByOrderNumber($post->id, $resultOrder);
                        if (!empty($result)) {
                            $assignedResultId = $result->id;
                        }
                    }
                    $data = [
                        'image_path' => inputPost('answer_image_' . $answer->id),
                        'image_storage' => inputPost('answer_image_storage_' . $answer->id),
                        'answer_text' => inputPost('answer_text_' . $answer->id),
                        'is_correct' => $isCorrect,
                        'assigned_result_id' => $assignedResultId
                    ];
                    $this->builderAnswers->where('id', $answer->id)->update($data);
                }
            }
        }
    }

    //get quiz question answers
    public function getQuizQuestionAnswers($questionId)
    {
        return $this->builderAnswers->where('question_id', cleanNumber($questionId))->orderBy('id')->get()->getResult();
    }

    //get quiz question answer
    public function getQuizQuestionAnswer($id)
    {
        return $this->builderAnswers->where('id', cleanNumber($id))->get()->getRow();
    }

    //get quiz question correct answer
    public function getQuizQuestionCorrectAnswer($questionId)
    {
        $row = $this->builderAnswers->where('question_id', cleanNumber($questionId))->where('is_correct = 1')->get()->getRow();
        if (empty($row)) {
            $row = $this->builderAnswers->where('question_id', cleanNumber($questionId))->orderBy('id')->get(1)->getRow();
        }
        return $row;
    }

    //delete quiz question answer
    public function deleteQuizQuestionAnswer($id)
    {
        $answer = $this->getQuizQuestionAnswer($id);
        if (!empty($answer)) {
            $this->builderAnswers->where('id', $answer->id)->delete();
        }
    }

    //delete quiz question answers
    public function deleteQuizQuestionAnswers($questionId)
    {
        $answers = $this->getQuizQuestionAnswers($questionId);
        if (!empty($answers)) {
            foreach ($answers as $answer) {
                $this->deleteQuizQuestionAnswer($answer->id);
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * RESULT
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz results
    public function addQuizResults($postId)
    {
        $resultTitles = inputPost('result_title');
        $resultImages = inputPost('result_image');
        $resultImageStorages = inputPost('result_image_storage');
        $resultDescriptions = inputPost('result_description');
        $minCorrectCounts = inputPost('min_correct_count');
        $maxCorrectCounts = inputPost('max_correct_count');
        $resultOrders = inputPost('result_order');
        if (!empty($resultTitles)) {
            for ($i = 0; $i < countItems($resultTitles); $i++) {
                $data = [
                    'post_id' => $postId,
                    'result_title' => !empty($resultTitles[$i]) ? $resultTitles[$i] : '',
                    'image_path' => !empty($resultImages[$i]) ? $resultImages[$i] : '',
                    'image_storage' => !empty($resultImageStorages[$i]) ? $resultImageStorages[$i] : '',
                    'description' => !empty($resultDescriptions[$i]) ? $resultDescriptions[$i] : '',
                    'min_correct_count' => !empty($minCorrectCounts[$i]) ? $minCorrectCounts[$i] : '',
                    'max_correct_count' => !empty($maxCorrectCounts[$i]) ? $maxCorrectCounts[$i] : '',
                    'result_order' => !empty($resultOrders[$i]) ? $resultOrders[$i] : 1
                ];
                $this->builderResults->insert($data);
            }
        }
    }

    //add quiz result
    public function addQuizResult($postId)
    {
        $data = [
            'post_id' => $postId,
            'result_title' => '',
            'image_path' => '',
            'image_storage' => '',
            'description' => '',
            'min_correct_count' => 1,
            'max_correct_count' => 2
        ];
        if ($this->builderResults->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //edit quiz results
    public function editQuizResults($post)
    {
        if (!empty($post)) {
            if (!checkPostOwnership($post->user_id)) {
                return false;
            }
            $results = $this->getQuizResults($post->id);
            if (!empty($results)) {
                foreach ($results as $result) {
                    $data = [
                        'result_title' => inputPost('result_title_' . $result->id),
                        'image_path' => inputPost('result_image_' . $result->id),
                        'image_storage' => inputPost('result_image_storage_' . $result->id),
                        'description' => inputPost('result_description_' . $result->id),
                        'min_correct_count' => inputPost('min_correct_count_' . $result->id),
                        'max_correct_count' => inputPost('max_correct_count_' . $result->id),
                        'result_order' => inputPost('result_order_' . $result->id)
                    ];
                    $this->builderResults->where('id', $result->id)->update($data);
                }
            }
        }
    }

    //get quiz results
    public function getQuizResults($postId)
    {
        return $this->builderResults->where('post_id', cleanNumber($postId))->orderBy('id')->get()->getResult();
    }

    //get quiz result
    public function getQuizResult($id)
    {
        return $this->builderResults->where('id', cleanNumber($id))->get()->getRow();
    }

    //get quiz result by order number
    public function getQuizResultByOrderNumber($postId, $order)
    {
        return $this->builderResults->where('post_id', cleanNumber($postId))->where('result_order', cleanNumber($order))->get()->getRow();
    }

    //delete quiz result
    public function deleteQuizResult($id)
    {
        $result = $this->getQuizResult($id);
        if (!empty($result)) {
            $this->builderResults->where('id', $result->id)->delete();
        }
    }

    //delete quiz results
    public function deleteQuizResults($postId)
    {
        $results = $this->getQuizResults($postId);
        if (!empty($results)) {
            foreach ($results as $result) {
                $this->deleteQuizResult($result->id);
            }
        }
    }

}
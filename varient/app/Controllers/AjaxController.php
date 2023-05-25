<?php

namespace App\Controllers;

use App\Models\NewsletterModel;
use App\Models\PollModel;
use App\Models\PostAdminModel;
use App\Models\QuizModel;
use App\Models\ReactionModel;
use App\Models\SettingsModel;
use Config\Globals;

class AjaxController extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!$this->request->isAJAX()) {
            exit();
        }
    }

    /**
     * Set Theme Mode Post
     */
    public function setThemeModePost()
    {
        checkAdmin();
        $this->settingsModel->setThemeMode();
        exit();
    }

    /**
     * Load More Posts
     */
    public function loadMorePosts()
    {
        $limit = cleanNumber(inputPost('limit'));
        $view = inputPost('view');
        $newLimit = $limit + POST_NUM_LOAD_MORE;
        $latestPosts = getLatestPosts($newLimit + 2);
        $hideButton = false;
        if (countItems($latestPosts) <= $newLimit) {
            $hideButton = true;
        }
        $widgets = getCategoryWidgets(0, $this->widgets, $this->adSpaces, $this->activeLang->id);
        if (!empty($latestPosts)) {
            $htmlContent = '';
            $i = 1;
            foreach ($latestPosts as $post) {
                if ($i > $limit && $i <= $newLimit) {
                    if ($view == '_post_item_horizontal' && $this->activeTheme->theme == 'classic') {
                        $vars = ['post' => $post, 'showLabel' => true];
                        $htmlContent .= loadView('post/_post_item_horizontal', $vars);
                    } else {
                        $vars = ['postItem' => $post, 'showLabel' => true];
                        $divClass = $widgets->hasWidgets ? 'col-sm-12 col-md-6' : 'col-sm-12 col-md-4';
                        $htmlContent .= ' <div class="' . $divClass . '">' . loadView('post/_post_item', $vars) . '</div>';
                    }
                }
                $i++;
            }
            $data = [
                'result' => 1,
                'htmlContent' => $htmlContent,
                'newLimit' => $newLimit,
                'hideButton' => $hideButton
            ];
            echo json_encode($data);
        } else {
            echo json_encode(['result' => 0]);
        }
    }

    /**
     * Get Quiz Answers
     */
    public function getQuizAnswers()
    {
        $postId = inputPost('post_id');
        $arrayQuizAnswers = array();
        $quizModel = new QuizModel();
        $questions = $quizModel->getQuizQuestions($postId);
        if (!empty($questions)) {
            $i = 0;
            foreach ($questions as $question) {
                $correctAnswer = $quizModel->getQuizQuestionCorrectAnswer($question->id);
                if (!empty($correctAnswer)) {
                    $item = [$question->id, $correctAnswer->id];
                    array_push($arrayQuizAnswers, $item);
                }
                $i++;
            }
        }
        $data = [
            'result' => 1,
            'arrayQuizAnswers' => $arrayQuizAnswers,
        ];
        echo json_encode($data);
    }

    /**
     * Get Quiz Results
     */
    public function getQuizResults()
    {
        $postId = inputPost('post_id');
        $arrayQuizResults = array();
        $quizModel = new QuizModel();
        $results = $quizModel->getQuizResults($postId);
        if (!empty($results)) {
            foreach ($results as $result) {
                $vars = ['result' => $result];
                $htmlContent = loadView('post/details/_quiz_result', $vars);
                //array: [0]: result id, [1]: min correct, [2]: max correct, [3]: html content
                $item = [$result->id, $result->min_correct_count, $result->max_correct_count, $htmlContent];
                array_push($arrayQuizResults, $item);
            }
        }
        $data = [
            'result' => 1,
            'arrayQuizResults' => $arrayQuizResults,
        ];
        echo json_encode($data);
    }

    /**
     * Add Poll Vote
     */
    public function addPollVote()
    {
        $pollId = inputPost('poll_id');
        $option = inputPost('option');
        $jsonData = array(
            'result' => 1,
            'htmlContent' => '',
        );
        if (is_null($option) || $option == '') {
            $jsonData['htmlContent'] = 'required';
        } else {
            $pollModel = new PollModel();
            $data['poll'] = $pollModel->getPoll($pollId);
            if (!empty($data['poll'])) {
                $result = "";
                if ($data['poll']->vote_permission == 'registered') {
                    $result = $pollModel->addVoteRegistered($pollId, $option);
                } else {
                    $result = $pollModel->addVoteUnRegistered($pollId, $option);
                }
                if ($result == 'success') {
                    $data['poll'] = $pollModel->getPoll($pollId);
                    $jsonData['htmlContent'] = view('common/_poll_results', $data);
                } else {
                    $jsonData['htmlContent'] = 'voted';
                }
            }
        }
        echo json_encode($jsonData);
    }

    /**
     * Add or Remove Reading List Item
     */
    public function addRemoveReadingListItem()
    {
        $postId = cleanNumber(inputPost('post_id'));
        if ($this->postModel->isPostInReadingList($postId) == true) {
            $this->postModel->addRemoveReadingListItem($postId, 'remove');
        } else {
            $this->postModel->addRemoveReadingListItem($postId, 'add');
        }
    }

    /**
     * Make Reaction
     */
    public function addReaction()
    {
        $postId = cleanNumber(inputPost('post_id'));
        $reaction = cleanStr(inputPost('reaction'));
        $data['post'] = getPostById($postId);
        $data['resultArray'] = array();
        if (!empty($data['post'])) {
            $reactionModel = new ReactionModel();
            $data['resultArray'] = $reactionModel->addReaction($postId, $reaction);
        }
        $data['reactions'] = $reactionModel->getReaction($postId);
        $jsonData = [
            'result' => 1,
            'htmlContent' => view('common/_emoji_reactions', $data)
        ];
        echo json_encode($jsonData);
    }

    /**
     * Add Comment
     */
    public function addCommentPost()
    {
        if ($this->generalSettings->comment_system != 1) {
            exit();
        }
        $limit = cleanNumber(inputPost('limit'));
        $postId = cleanNumber(inputPost('post_id'));
        if (authCheck()) {
            $this->commonModel->addComment();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) != 'invalid') {
                $this->commonModel->addComment();
            }
        }
        if ($this->generalSettings->comment_approval_system == 1 && !checkUserPermission('comments_contact')) {
            $jsonData = [
                'type' => 'message',
                'htmlContent' => "<p class='comment-success-message'><i class='icon-check'></i>&nbsp;&nbsp;" . trans("msg_comment_sent_successfully") . '</p>'
            ];
            echo json_encode($jsonData);
        } else {
            $this->loadCommentsData($postId, $limit);
        }
    }

    /**
     * Load Subcomment Box
     */
    public function loadSubcommentBox()
    {
        $commentId = cleanNumber(inputPost('comment_id'));
        $limit = cleanNumber(inputPost('limit'));
        $data['parentComment'] = $this->commonModel->getComment($commentId);
        $data['commentLimit'] = $limit;
        $htmlContent = view('common/_add_subcomment', $data);
        echo json_encode(['result' => 1, 'htmlContent' => $htmlContent]);
    }

    /**
     * Load More Comments
     */
    public function loadMoreComments()
    {
        $postId = cleanNumber(inputPost('post_id'));
        $limit = cleanNumber(inputPost('limit'));
        $newLimit = $limit + COMMENT_LIMIT;
        $this->loadCommentsData($postId, $newLimit);
    }

    /**
     * Like Comment
     */
    public function likeCommentPost()
    {
        $commentId = cleanNumber(inputPost('comment_id'));
        $data = [
            'result' => 1,
            'likeCount' => $this->commonModel->likeComment($commentId)
        ];
        echo json_encode($data);
    }

    /**
     * Delete Comment
     */
    public function deleteCommentPost()
    {
        $id = cleanNumber(inputPost('id'));
        $postId = cleanNumber(inputPost('post_id'));
        $limit = cleanNumber(inputPost('limit'));
        $comment = $this->commonModel->getComment($id);
        if (authCheck() && !empty($comment)) {
            if (user()->role == 'admin' || user()->id == $comment->user_id) {
                $this->commonModel->deleteComment($id);
            }
        }
        $this->loadCommentsData($postId, $limit);
    }

    //load comments data
    private function loadCommentsData($postId, $limit)
    {
        $data = [
            'post' => getPostById($postId),
            'comments' => $this->commonModel->getComments($postId, $limit),
            'commentCount' => $this->commonModel->getCommentCountByPostId($postId),
            'commentLimit' => $limit,
        ];
        $jsonData = [
            'result' => 1,
            'htmlContent' => view('common/_comments', $data)
        ];
        echo json_encode($jsonData);
        exit();
    }

    /**
     * Add to Newsletter
     */
    public function addNewsletterPost()
    {
        $url = inputPost('url');
        if (!empty($url)) {
            exit();
        }
        $data = [
            'result' => 0,
            'htmlContent' => '',
            'isSuccess' => '',
        ];
        $email = cleanStr(inputPost('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['htmlContent'] = '<p class="text-danger m-t-5">' . trans("message_invalid_email") . '</p>';
        } else {
            if (!empty($email)) {
                $newsletterModel = new NewsletterModel();
                if (empty($newsletterModel->getSubscriber($email))) {
                    if ($newsletterModel->addSubscriber($email)) {
                        $data['htmlContent'] = '<p class="text-success m-t-5">' . trans("message_newsletter_success") . '</p>';
                        $data['isSuccess'] = 1;
                    }
                } else {
                    $data['htmlContent'] = '<p class="text-danger m-t-5">' . trans("message_newsletter_error") . '</p>';
                }
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Close Cookies Warning
     */
    public function closeCookiesWarningPost()
    {
        helperSetCookie('cookies_warning', '1');
    }
}

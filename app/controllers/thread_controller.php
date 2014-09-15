<?php

/**
* class ThreadController
**/
class ThreadController extends AppController
{
    /**
    *   In progress (WORKING)
    **/
    public function home()
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }
        $threads = Thread::getThreads();
        $members = User::getNewMembers();

        //to get posts with highest number of threads
        $trends = Comment::getTrends();
        $trend_title = Thread::getTrendTitle($trends);
        $this->set(get_defined_vars());
    }

    /**
    * To edit logged-in user's posts/comments
    * IN PROGRESS (WORKING)
    **/
    public function update()
    {
        $id = Param::get('id');
        $new_title = Param::get('title');
        $task = Param::get('task');
        if ($task == 'edit') {
            $title = Thread::changeTitle($id, $new_title);
        } else if ($task == 'delete') {
            $title = Thread::deleteThread($id);
        } else {
            redirect(url('thread/index'));
        }
    }

    /**
    * To get logged-in users's threads
    * Used for checking
    * Function is subject for modification (WORKING)
    **/
    public function myposts()
    {
        $post = array();
        $own_threads = Thread::myposts();
        $own_comments = Comment::mycomments();
        $thread = Thread::getTrendTitle($own_comments);
        //echo "<pre>", print_r($own_threads), "</pre>";
        $this->set(get_defined_vars());
    }

    /**
    *   To view all threads with limits and categories
    **/
    public function index()
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }

        $page = Pagination::setPage(Param::get('page'));
        
        //to get posts with highest number of threads
        $trends = Comment::getTrends();
        $trend_title = Thread::getTrendTitle($trends);

        //to get posts according to their category
        $search = Param::get('search');
        $category = Param::get('filter');
        $date = Param::get('date');
        $trend = Param::get('trend');
        $row_count = Thread::getNumRowsCat($category, $date, $search);

        if($category == 0 && $date == 0 && $search == '') $row_count = Thread::getNumRows();

        $threads = Thread::filter($category, $date, $page, $search);
        $links = Pagination::createPages($page, $row_count);
        $this->set(get_defined_vars());
    }

    /**
    *  To write new comment
    *  @property username
    *       set as the $_SESSION['username']
    **/
    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->username = $_SESSION['username'];
                $comment->body = Param::get('body');
                try {
                    $thread->write($comment);
                } catch (ValidationException $e) {
                    $page='write';
                }
                break;

            default:
                throw new NotFoundException("{$page} is not found");
                break;      
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
    * To create new thread with comment.
    **/
    public function create()
    {
        $thread = new Thread;
        $thread->category = Param::get('select');
        $thread->user_id = $_SESSION['user_id'];
        $comment = new Comment;
        $page = Param::get('page_next', 'create');
        $username = $_SESSION['username'];

        switch ($page) {
            case 'create':
                break;
            case 'create_end';
                $thread->title = Param::get('title');
                $comment->username = $username;
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
    * To destroy user session
    * 
    **/
    function logout()
    {
        session_destroy();
        redirect(url('user/index'));
    }
}
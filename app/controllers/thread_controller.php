<?php

/**
* class ThreadController
*
**/
class ThreadController extends AppController
{
    
    public function __contruct()
    {
        $username = $_SESSION['username'];
        $this->set(get_defined_vars());
    }

    /**
    *   In progress
    **/
    public function home()
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }
        //$links = Pagination::createPages(Param::get('page'), Thread::getNumRows());
        $threads = Thread::getThreads();
        $members = User::getNewMembers();
        $trends = Comment::getTrends();
        $trend_title = Thread::getTrendTitle($trends);
        $this->set(get_defined_vars());
    }

    /**
    *   To view all threads with limits through Pagination.
    **/
    public function index()
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }
        $links = Pagination::createPages(Param::get('page'), Thread::getNumRows());
        $threads = Thread::getAll();
        $row_count = Thread::getNumRows();
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


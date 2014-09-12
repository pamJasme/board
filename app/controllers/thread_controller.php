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
        $id = Param::get('othreads');
        $new_title = Param::get('new_title');
        if (Param::get('delete') != '0') {    
            $title = Thread::changeTitle($id,$new_title);
            echo $title;
        } else {
            $deleted = Thread::deleteThread($id);
            echo $deleted;
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
        $title = Thread::getTrendTitle($own_comments);
        $merge = Thread::commentsThreads($own_comments, $title);
        //echo "<pre>",print_r($merge), "</pre>";
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
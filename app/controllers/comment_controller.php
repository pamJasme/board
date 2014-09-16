<?php
 
class CommentController extends AppController
{
    /**
    * To view all comments on a particular thread.
    **/
    public function view()
    {
        $page = Pagination::setPage(Param::get('page'));
        $row_count = Comment::getNumComments(Param::get('thread_id'));
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments($page);
        $user_name = $_SESSION['username'];
        Pagination::$pagination_page = 'comment';
        $links = Pagination::createPages($page, $row_count);
        $this->set(get_defined_vars());
    }

    /**
    * To edit logged-in user's posts/comments
    * IN PROGRESS (Working)
    **/
    public function update()
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }
        
        $id = Param::get('id');
        $new_body = Param::get('body');
        switch (Param::get('task')) {
            case 'edit':
                Comment::changeComment($id, $new_body);
                break;
            case 'delete':
                Comment::deleteComment($id);
                redirect(url('thread/index'));
                break;
            default:
                redirect(url('thread/index'));
                break;
        }
    }
}
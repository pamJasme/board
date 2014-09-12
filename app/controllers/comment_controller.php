<?php
 
class CommentController extends AppController{

    /**
    * To view all comments on a particular thread.
    **/
    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();
        $user_name = $_SESSION['username'];
        $this->set(get_defined_vars());
    }

    /**
    * To edit logged-in user's posts/comments
    * IN PROGRESS (Working)
    **/
    public function update()
    {
        $id = Param::get('id');
        $new_body = Param::get('body');
        $task = Param::get('task');
        if ($task == 'edit') {
            $title = Comment::changeComment($id, $new_body);
        } else if ($task == 'delete') {
            $title = Comment::deleteComment($id);
        } else {
            redirect(url('thread/index'));
        }
    }
}
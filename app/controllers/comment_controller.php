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

}


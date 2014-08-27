<?php
 
 class CommentController extends AppController{

  /**
    *   To view all comments on a particular thread.
    **/
    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();

        $this->set(get_defined_vars());
    }
}
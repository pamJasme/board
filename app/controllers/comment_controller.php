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
}


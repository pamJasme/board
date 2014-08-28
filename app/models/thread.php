<?php

/**
* class Thread 
*/
class Thread extends AppModel
{
    public $validation =array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
                ),
            ),
        );

    /**
    * To create comment
    * @param $comment
    * @throws ValidationException
    **/
    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment -> hasError()) {
            throw new ValidationException('invalid thread or comment');
        }
        $db = DB::conn();
        $db->begin();
        $db->insert('thread', array('title' => $this->title));
        $this->id = $db->lastInsertId();

        //write first comment at the same time
        $this->write($comment);
        $db->commit();
    }

    /**
    * To view all threads with limit
    **/
    public static function getAll($max)
    {
        $threads = array();
        $limits = $max;
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread $limits");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        return $threads;
    }

    /**
    * To search a thread through thread id
    * @param $id
    **/
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));
        if (!$row) {
            redirect("thread", "index");
        }
        return new self($row);
    }

    /**
    * To view comments in ascending order
    **/
    public function getComments()
    {
        $comments = array();
        $db = DB::conn();
        $rows = $db->search('comment', 'thread_id = ?', array($this->id), 'created ASC');
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        return $comments;
    }

    /**
    * To add comments into a particular thread
    * @param $comment
    **/
    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $params = array(
            'thread_id' => $this->id,
            'username' => $comment->username,
            'body' => $comment->body,
            );
        $db->insert('comment', $params);
    }

    /**
    * Function to count table rows
    **/
    public static function getNumRows()
    {
        $db = DB::conn();
        $count = $db->value("SELECT COUNT(*) FROM thread");
        return $count;  
    }
}


<?php

/**
* class Thread 
*/
class Thread extends AppModel
{
    const MIN_VALUE = 1;    
    const MAX_TITLE_LENGTH = 30;

    public $validation =array(
        'title' => array(
            'length' => array(
                'validate_between', self::MIN_VALUE, self::MAX_TITLE_LENGTH,
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
        try {
            $db->begin();
            $db->insert('thread', array('title' => $this->title));
            $this->id = $db->lastInsertId();

            //write first comment at the same time
            $this->write($comment);
            $db->commit();
        } catch(ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    /**
    * To view all threads with limit
    **/
    public static function getAll($max)
    {
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread $max");
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
        new self($rows);
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


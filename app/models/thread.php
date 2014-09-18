<?php

/**
* class Thread 
*/
class Thread extends AppModel
{
    const MIN_VALUE = 1;    
    const MAX_TITLE_LENGTH = 30;
    const HOME_THREADS = 15;
    const DEFAULT_OPTION_ALL = 0;
    const CATEGORY_JOB = 1;
    const CATEGORY_LOVE = 2;
    const CATEGORY_OTHERS = 3;
    const DATE_FILTER_YESTERDAY = 1;
    const DATE_FILTER_ONE_WEEK = 5;
    const DATE_FILTER_ONE_MONTH = 30;

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
            $params = array(
                'title' => $this->title,
                'category' => $this->category,
                'user_id' => $this->user_id,
                'created' => date('Y-m-d h:i:s'),
            );
            $db->insert('thread', $params);
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
    * To change thread title
    **/
    public static function changeTitle($id, $title)
    {
        if (!isset($title)) {
            $status = "";
            return $status;
        }

        if (!validate_between($title, self::MIN_VALUE, self::MAX_TITLE_LENGTH)) {
            throw new ValidationException("<span class='label label-important'>Invalid title!</span>");
        }
        $db = DB::conn();
        $update = $db->update('thread', array('title' => $title, 'updated' => date('Y-m-d h:i:s')), 
            array('id' =>  $id));
        return "<span class='label label-success'>Successfully changed!</span>";
    }

    /**
    * To delete thread
    **/
    public static function deleteThread($id, $user_id) 
    {
        $db = DB::conn();
        $search = $db->search('comment', 'thread_id = ?', array($id));
        $query = "DELETE FROM thread";
        if (!$search) {
            $query .= " WHERE id = ?";
            $params = array($id);
        } else {
            $query .= ", comment USING thread INNER JOIN comment
                ON thread.id=comment.thread_id WHERE thread.id = ? AND thread.user_id = ?";
            $params = array($id, $user_id);
        }
        $db->query($query, $params);
    }

    /**
    * To get logged-in users's threads
    **/
    public static function myPosts($page)
    {
        $own_posts = array();
        $db = DB::conn();
        $id = $_SESSION['user_id'];
        $rows = $db->rows("SELECT * from thread
            WHERE user_id = ? ORDER BY created DESC", array($id));
        foreach ($rows as $row) {
            $own_posts[] = new Thread($row);
        }
        $limit = Pagination::ROWS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        return array_slice($own_posts, $offset, $limit);
    }

    /*
    * To filter threads by category
    * To search threads
    * @params $cat_id, $date, $page, $search
    */
    public static function filter($cat_id, $date, $page, $search)
    {
        $filter_threads = array();
        $query = "SELECT * FROM thread WHERE ";
        $db = DB::conn();
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime("-{$date} days"));
        $like_clause = "title LIKE ?";
        $keyword = "%$search%";

        if ($date == 0 && $cat_id == 0) {
            $query .= "$like_clause";
            $params = array($keyword);
        } elseif ($date == 0) {
            $query .= "category = ? AND {$like_clause}";
            $params = array($cat_id, $keyword);
        } elseif ($cat_id == 0) {
            $query .= "created BETWEEN ? AND ? AND {$like_clause}";
            $params = array($start, $end, $keyword);
        } else {
            $query .= "category = ? AND created BETWEEN ? AND ? AND {$like_clause}";
            $params = array($cat_id, $start, $end, $keyword);
        }

        $rows = $db->rows($query, $params);
        foreach ($rows as $row) {
                $filter_threads[] = new Thread($row);
        }

        foreach ($filter_threads as $key) {
            $username = User::getUsername($key->user_id);
            $key->username = $username;
            $count = Comment::getNumComments($key->id);
            $key->count = $count;
        }

        $limit = Pagination::ROWS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        return array_slice($filter_threads, $offset, $limit);
    }

    /**
    * To view all threads with page limit
    **/
    public static function getAll($page)
    {
        $threads = array();
        $db = DB::conn();

        $rows = $db->rows("SELECT * FROM thread ORDER BY updated DESC");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        $limit = Pagination::ROWS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        return array_slice($threads, $offset, $limit);
    }

    
    public static function getTrendTitle($thread_comments)
    {
        $threads = array();
        $db = DB::conn();
        $thread_ids = array_keys($thread_comments);
        $rows = $db->rows('SELECT * FROM thread WHERE id IN (?) ', array($thread_ids));
        foreach ($rows as $row) {
            $row['comment_count'] = $thread_comments[$row['id']];
            $threads[] = new self($row);
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
            redirect(url('thread/index'));
        }
        return new self($row);
    }

    /**
    * To view comments in ascending order
    **/
    public function getComments($page)
    {
        $comments = array();
        $db = DB::conn();
        $rows = $db->search('comment', 'thread_id = ?', array($this->id), 'created DESC');
        if (!$rows) {
            return "none";
        }
        new self($rows);
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        $limit = Pagination::ROWS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        return array_slice($comments, $offset, $limit);
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
            'user_id' => $_SESSION['user_id'],
        );
        $db->insert('comment', $params);
        $db->update('thread', array('updated' => date('Y-m-d h:i:s')), array('id' => $this->id));
    }

    /**
    * To count number of rows (All)
    */
    public static function getRowCount()
    {
        $db = DB::conn();
        $count = $db->value("SELECT COUNT(*) from thread");
        return $count;
    }

    /**
    * To count table rows with category
    **/
    public static function getRowCountCategory($cat_id, $date, $search)
    {
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime("-{$date} days"));
        $query = "SELECT COUNT(*) FROM thread WHERE ";
        $db = DB::conn();
        $like_clause = "title LIKE ?";
        $keyword = "%$search%";
        if ($date == 0 && $cat_id == 0) {
            $query .= "$like_clause";
            $params = array($keyword);
        } elseif ($cat_id == 0) {
            $query .= "created BETWEEN ? AND ? AND {$like_clause}";
            $params = array($start, $end, $keyword);
        } elseif ($date == 0) {
            $query .= "category = ? AND {$like_clause}";
            $params = array($cat_id, $keyword);
        } else {
            $query .= "category = ? AND created BETWEEN ? AND ? AND {$like_clause}";
            $params = array($cat_id, $start, $end, $keyword);
        }
        $count = $db->value($query, $params);
        return $count;  
    }
}
<?php

/**
* class Thread 
*/
class Thread extends AppModel
{
    const MIN_VALUE = 1;    
    const MAX_TITLE_LENGTH = 30;
    const HOME_THREADS = 15;

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
        $date = date('Y-m-d h:i:s');
        $db = DB::conn();
        try {
            $db->begin();
            $params = array(
                'title' => $this->title,
                'category' => $this->category,
                'user_id' => $this->user_id,
                'created' => $date,
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
        if (!$is_logged_in) {
            redirect(url('user/index'));
        }

        $db = DB::conn();
        $db->update('thread', array('title' => $title), array('id' =>  $id));
        $status = "Successfully change";
        return $status;
    }

    /**
    * To delete thread
    **/
    public static function deleteThread($id) 
    {
        if (!$is_logged_in) {
            redirect(url('user/index'));
        }

        $db = DB::conn();
        $db->query("DELETE FROM thread WHERE id = ?", array($id));
        $status = "Successfully deleted";
        return $status;
    }

    /**
    * To get logged-in users's threads
    * Used for checking
    * Function is subject for modification
    **/
    public static function myposts()
    {
        $own_posts = array();
        $db = DB::conn();
        $id = $_SESSION['user_id'];
        $rows = $db->rows("SELECT * from thread WHERE user_id = ?", array($id));
        foreach ($rows as $row) {
            $own_posts[] = new Thread($row);
        }
        return $own_posts;
    }

    /*
    * To filter threads by category
    * To search threads
    * @params $cat_id, $date, $page, $search
    */
    public static function filter($cat_id, $date, $page, $search)
    {
        echo $search;
        $filter_threads = array();
        $db = DB::conn();
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime("-{$date} days"));
        $like_clause = "title LIKE ?";
        $keyword = "%$search%";

        if ($date == 0 && $cat_id == 0) {
            $rows = $db->rows("SELECT * FROM thread WHERE {$like_clause}", array($keyword));
            foreach ($rows as $row) {
                $filter_threads[] = new Thread($row);
            }
        } 

        if ($date == 0) {
            $rows = $db->rows("SELECT * FROM thread 
            WHERE category = ? AND {$like_clause}", array($cat_id, $keyword));
            foreach ($rows as $row) {
                $filter_threads[] = new Thread($row);
            }
        } else if ($cat_id == 0) {
            $rows = $db->rows("SELECT * FROM thread 
            WHERE created BETWEEN ? AND ? AND {$like_clause}", array($start, $end, $keyword));
            foreach ($rows as $row) {
                $filter_threads[] = new Thread($row);
            }
        } else {
            $rows = $db->rows("SELECT * FROM thread 
            WHERE category = ? AND created BETWEEN ? AND ? AND {$like_clause}", array($cat_id, $start, $end, $keyword));
            foreach ($rows as $row) {
                $filter_threads[] = new Thread($row);
            }
        }

        foreach ($filter_threads as $key) {
            $user = User::getUsername($key->user_id);
            $key->user = $user;
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
        $rows = $db->rows("SELECT * FROM thread");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }
        
        $limit = Pagination::ROWS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        return array_slice($threads, $offset, $limit);
    }

    /**
    * To view threads for Home page
    **/
    public static function getThreads()
    {
        $all_threads = array();
        $max = self::HOME_THREADS;
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread LIMIT $max ");
        foreach ($rows as $row) {
            $all_threads[] = new Thread($row);
        }
        return $all_threads;
    }

    /**
    * To get logged-in users's threads together with it's comments
    * Used for checking
    * Function is subject for modification (WORKING)
    **/
    public static function commentsThreads($comments, $threads)
    {
        $id = $_SESSION['user_id'];
        $db = DB::conn();
        $row = $db->rows("SELECT t.title, c.body from comment c 
            INNER JOIN thread t ON c.thread_id=t.id 
            WHERE t.user_id = ?", array($id));
        return $row;
    }

    /**
    * To view threads for Home page
    **/
    public static function getTrendTitle($trend_id)
    {
        $trend_title = array();
        $db = DB::conn();
        foreach ($trend_id as $value) {
            $id = $value['thread_id'];
            $row = $db->row("SELECT * FROM thread where id = ?", array($id));
            $row['count'] = $value['count'];
            $trend_title[] = $row;
        }
            return $trend_title;
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
            'user_id' => $_SESSION['user_id'],
            );
        $db->insert('comment', $params);
    }

    /**
    * To count number of rows (All)
    */
    public static function getNumRows()
    {
        $db = DB::conn();
        $count = $db->value("SELECT COUNT(*) from thread");
        return $count;
    }

    /**
    * To count table rows with category
    **/
    public static function getNumRowsCat($cat_id, $date, $search)
    {
        $end = date('Y-m-d');
        $start = date('Y-m-d', strtotime("-{$date} days"));
        $db = DB::conn();
        $like_clause = "title LIKE ?";
        $keyword = "%$search%";
        if ($cat_id == 0) {
            $count = $db->value("SELECT COUNT(*) FROM thread 
            WHERE created BETWEEN ? AND ? AND {$like_clause}", array($start, $end, $keyword));
        } else if ($date == 0) {
            $count = $db->value("SELECT COUNT(*) FROM thread 
               WHERE category = ? AND {$like_clause}", array($cat_id, $keyword));
        } else {
             $count = $db->value("SELECT COUNT(*) FROM thread 
            WHERE category = ? AND created BETWEEN ? AND ? AND {$like_clause}", array($cat_id, $start, $end, $keyword));
        }
        return $count;  
    }
}
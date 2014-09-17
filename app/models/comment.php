<?php
class Comment extends AppModel
{
    const MIN_VALUE = 1;
    const USERNAME_MAX_VALUE = 16;
    const BODY_MAX_VALUE = 200;
    const TREND_COUNT = 10;
    const COMMENT_DISPLAY_COUNT = 1;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', self::MIN_VALUE, self::USERNAME_MAX_VALUE,
            ),
        ),
        'body' => array(
            'length' => array(
                'validate_between', self::MIN_VALUE, self::BODY_MAX_VALUE,
            ),
        ),
    );

    /**
    * To view threads according to comment count
    **/
    public static function getTrends()
    {
        $thread_comments = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT thread_id, COUNT(*) AS 'comment_count' FROM comment 
            GROUP BY thread_id ORDER BY comment_count DESC LIMIT " . self::TREND_COUNT);
        foreach ($rows as $row) {
            $thread_comments[$row['thread_id']] = $row['comment_count'];
        }
        return $thread_comments;        
    }



    /**
    * To get logged-in user's thread comments
    */
    public static function myComments($id)
    {
        $my_comments = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT *, (SELECT COUNT(*) FROM comment) 
            comment_count FROM comment INNER JOIN thread
            ON comment.thread_id = thread.id 
            WHERE comment.user_id = ? ORDER BY comment.created 
                DESC LIMIT " . self::TREND_COUNT, array($id));
        foreach($rows as $row) {
            $my_comments[] = new Thread($row);
        }
        return $my_comments;
        
    }

    /**
    * To get number of comments on a thread
    * @param $id
    **/
    public static function getNumComments($id)
    {
        $db = DB::conn();
        $rows = $db->value("SELECT COUNT(*) FROM comment WHERE thread_id = ?", array($id));
        return $rows;
    }

    /**
    * To change comments on a thread
    * @param $id, $body
    **/
    public static function changeComment($id, $body)
    { 
        if (!isset($body)) {
            $status = "";
            return $status;
        }

        if (!validate_between($body, self::MIN_VALUE, self::BODY_MAX_VALUE)) {
            throw new ValidationException("Invalid input");
        }
        $db = DB::conn();
        $db->update('comment', array('body' => $body), array('id' =>  $id));
    }

    /**
    * To delete comments on a thread
    * @param $id
    **/
    public static function deleteComment($id) 
    {
        $db = DB::conn();
        $db->query("DELETE FROM thread WHERE id = ?", array($id));
    }

    /**
    * To get latest comment on a thread
    * @param $threads
    **/
    public static function getThreadComments($threads)
    {
        $thread_comments = array();
        $db = DB::conn();
        foreach ($threads as $key) {
            $thread_comments[] = $db->row("SELECT comment.body, thread.title,  
                user_info.username, thread.id FROM comment INNER JOIN thread
                ON thread.id = comment.thread_id INNER JOIN user_info ON
                comment.user_id=user_info.user_id
                WHERE thread.id = ? ORDER BY comment.created 
                DESC LIMIT " . self::COMMENT_DISPLAY_COUNT, array($key->id));
        }
        return $thread_comments;
    }
}


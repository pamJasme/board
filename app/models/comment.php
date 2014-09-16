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
        $db = DB::conn();
        $row = $db->rows("SELECT thread_id, COUNT(*) AS 'comment_count' FROM comment 
            GROUP BY thread_id ORDER BY comment_count DESC LIMIT " . self::TREND_COUNT);
        return $row;
    }

    /**
    * To get logged-in user's thread comments
    * In-progress (Working)
    */
    public static function myComments($id)
    {
        $db = DB::conn();
        $rows = $db->rows("SELECT *, (SELECT COUNT(*) FROM comment) 
            comment_count FROM comment INNER JOIN thread
            ON comment.thread_id = thread.id 
            WHERE thread.user_id = ? ORDER BY comment.created 
                DESC LIMIT " . self::TREND_COUNT, array($id));
        return $rows;
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
            $thread_comments[] = $db->row("SELECT * FROM comment INNER JOIN thread
                ON thread.id = comment.thread_id
                WHERE thread.id = ? ORDER BY comment.created 
                DESC LIMIT " . self::COMMENT_DISPLAY_COUNT, array($key->id));
        }
        return $thread_comments;
    }
}


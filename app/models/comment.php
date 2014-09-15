<?php
class Comment extends AppModel
{
    const MIN_VALUE = 1;
    const USERNAME_MAX_VALUE = 16;
    const BODY_MAX_VALUE = 200;
    const TREND_COUNT = 10;

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
        $trends = array();
        $max = self::TREND_COUNT;
        $db = DB::conn();
        $row = $db->rows("SELECT thread_id, COUNT(*) AS 'count' FROM comment 
            GROUP BY thread_id ORDER BY COUNT(*) DESC LIMIT $max");
        return ($row);
    }

    /**
    * To get logged-in user's thread comments
    * In-progress (Working)
    */
    public static function myComments($id)
    {
        $db = DB::conn();
        $rows = $db->rows("SELECT *, COUNT(*) as 'count' FROM comment WHERE user_id = ?", array($id));
        return $rows;
    }

    public static function changeComment($id, $body)
    { 
        $db = DB::conn();
        $db->update('comment', array('body' => $body), array('id' =>  $id));
    }

    public static function deleteComment($id, $user_id) 
    {
        if (!is_logged_in()) {
            redirect(url('user/index'));
        }
        $db = DB::conn();
        $query = "DELETE FROM thread, comment USING thread INNER JOIN comment
            WHERE thread.id = ? AND comment.thread_id = ? AND thread.user_id = ?";
        $params = array($id, $id, $user_id);
        $db->query($query, $params);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


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
        $row = $db->rows("SELECT thread_id FROM comment 
            GROUP BY thread_id ORDER BY COUNT(*) DESC LIMIT $max");
        return ($row);
    }
}


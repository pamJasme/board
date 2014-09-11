<?php
class Pagination
{
	const ROWS_PER_PAGE = 5;
	const LINK_LIMIT = 2;
	public static $current_page = 1;

	public static function setPage($page)
	{
		if ($page > 1) {
			return self::$current_page = preg_replace('#[^0-9]#', '', $page);
		}
		return self::$current_page;
	}

	/*
	* To set Pagination's last page
	* @param $rowCount
	*/
	public static function setLastPage($rowCount)
	{
		if ($rowCount <= self::ROWS_PER_PAGE) {
			return 1;
		}
		return ceil($rowCount/self::ROWS_PER_PAGE);
	}

	/*
	* To create pages with links
	* @params $page, $rowCount
	*/
	public static function createPages($page, $rowCount)
	{
		
		$last_page = self::setLastPage($rowCount);
		if (isset($page)) {
			self::$current_page = preg_replace('#[^0-9]#', '', $page);
		}

		$links = "";
		$current_page = self::$current_page;
		$next_page = $current_page + 1;
		$prev_page = $current_page - 1;
		$previous = $current_page - self::LINK_LIMIT; 
		$next = $current_page + self::LINK_LIMIT;
		if ($current_page == 1 ) {
			$links .= '<li class="active">
				<a href="#"><span>&laquo;</span></a></li><li>';
		}

		if ($last_page != 1) {
			$links .= self::createPrevLink($current_page, $prev_page);

			for ($i = $prev_page; $i < $current_page; $i++) {
				$links .= self::createLeftLinks($i);	
			}

			$links .= '<li class="active"><a href="#">'.$current_page.'</a></li><li>';

			for ($i = $next_page; $i <= $last_page; $i++) {
				$links .= self::createRightLinks($i, $next);
			}

			$links .= self::createNextLink($current_page, $next_page, $last_page);
		}
		
		if ($current_page == $last_page) {
			$links .= '<li class="active">
				<a href="#"><span>&raquo;</span></a></li><li>';
		}

		return $links;
	}

	/*
	* Move from previous page
	* @params $current_page, $prev_page
	*/
	public static function createPrevLink($current_page, $prev_page)
	{
		if ($current_page > 1) {
			return '<a href="?page=' . $prev_page . '&filter='. Param::get('filter') .
				'&date='.Param::get('date').'">
			<span>&laquo;</span></a> &nbsp; &nbsp; ';
		}
	}

	/*
	* To create links before the current page
	* @params $i as page number
	*/
	public static function createLeftLinks($i)
	{
		if ($i > 0) {
			return '<a href="?page=' . $i . '&filter='. Param::get('filter') .
				'&date='. Param::get('date') .'">' . $i . '</a> &nbsp; ' ;
		}
	}

	/*
	* To create links after the current page
	* @params $i as page number
	* @params $next
	*/
	public static function createRightLinks($i, $next)
	{
		if ($i <= $next) {
			return '<a href="?page=' . $i . '&filter='. Param::get('filter') .
				'&date='. Param::get('date').'">' . $i . '</a> &nbsp; ' ;
		}
	}

	/*
	* Move to next page
	* @params $current_page, $next_page, $last_page
	*/
	public static function createNextLink($current_page, $next_page, $last_page)
	{
		 if ($current_page != $last_page) {
		 	return '<a href="?page=' . $next_page . '&filter='. Param::get('filter') .
				'&date='. Param::get('date') .'">
			<span>&laquo;</span></a> &nbsp; &nbsp; ';
		}
	}

}
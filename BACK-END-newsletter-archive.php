<?php
/*
Template Name: Newsletter Archive
*/
get_header();

$months        = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$current_month = date('n');
$current_year  = date('Y');
$current_day   = date('d');
$month         = 0;

if($current_month = 12 && $current_day == 31) {
  $current_year = $current_year + 1;
}
?>
  <div class="row">
    <div class="<?php echo MAIN_COLUMN; ?>">
      <div class="article-page">
      <div class="newsletter-dropdown">
        <strong>Search By Year:</strong>
        <select id="newsletter-select">
        <option value=""></option>
        <?php
        $enddate = 1993;
        $current = 0;
        $years   = range ($current_year,$enddate);

        foreach($years as $year) {
          if ($current == 0) {
            $current++;
            echo '<option value="'.get_site_url().'/newsletter-archive">'.$year.'</option>';
          } else {
            echo '<option value="'.get_site_url().'/newsletter-archive-'.$year.'">'.$year.'</option>';
          }
        }
        ?>
        </select>
      </div>

      <?php
      $getTitle = get_the_title();
      $getPageYear = substr($getTitle, -4);
      $archive_calendar = get_transient( 'current_calendar_'.$getPageYear.'' );
      if ( false === $archive_calendar ) {
        ob_start();

        echo '<h1 class="article-title">' . $getTitle . '</h1><div class="calendar">';

        // Table of months
        for ($row=1; $row<=3; $row++) {
	        echo '<div class="row">';
	        for ($column=1; $column<=4; $column++) {
	   	      echo '<div class="month col-xs-12 col-sm-6 col-md-3">';
   		      $month++;

		        // Month Cell
            $first_day_in_month=date('w',mktime(0,0,0,$month,1,$getPageYear));
		        $month_days=date('t',mktime(0,0,0,$month,1,$getPageYear));

		        if ($first_day_in_month==0){
			        $first_day_in_month=7;
		        }

            echo '<table>';
		        echo '<th colspan="7">'.$months[$month-1].'</th>';
		        echo '<tr class="days"><td>Mo</td><td>Tu</td><td>We</td><td>Th</td><td>Fr</td>';
		        echo '<td class="sat">Sa</td><td class="sun">Su</td></tr>';
		        echo '<tr>';

            for($i=1; $i<$first_day_in_month; $i++) {
			        echo '<td> </td>';
		        }

            for($day=1; $day<=$month_days; $day++) {
			        $pos=($day+$first_day_in_month-1)%7;
			        $class = (($day==$current_day) && ($month==$current_month)) ? 'today' : 'day';
			        $class .= ($pos==6) ? ' sat' : '';
			        $class .= ($pos==0) ? ' sun' : '';

              $filename = 'pdf/tdn/'. $getPageYear.'/tdn' . substr($getPageYear, -2) . str_pad($month, 2, '0', STR_PAD_LEFT) . str_pad($day, 2, '0', STR_PAD_LEFT) . '.pdf';
              $date = $getPageYear.'-'.$month.'-'.$day;
              if (file_exists(ABSPATH . $filename)) {
                echo '<td class="day'.(strtotime($date) > strtotime("2015-11-10") ? ' world-split' : '').'"><a href="'.home_url( "/$filename" ).'">'.$day.'</a></td>';
              } else {
                echo '<td class="day'.(strtotime($date) > strtotime("2015-11-10") ? ' world-split' : '').'" rel="'.$date.'" data-filename="' . $filename . '">'.$day.'</td>';
              }
    	        if ($pos==0) echo '</tr><tr>';
		        }

            echo '</tr>';
		        echo '</table>';
		        echo '</div>';
	        }
	        echo '</div>';
        }
        echo '</div>';

      // save the output buffer contents in a variable
      $archive_calendar = ob_get_contents();

      // clean the buffer as we will be using the variable from now on
      ob_end_clean();

      // transient set to last for 24 hours
      set_transient('current_calendar_'.$getPageYear.'', $archive_calendar, 60*60*24);
    }
    echo $archive_calendar;
    ?>
      </div>
    </div>
    <div class="<?php echo SIDEBAR; ?>">
      <ins data-revive-zoneid="10" data-revive-id="87f8c64c2119fcebfcf45f47c9d598a5"></ins>
    </div>
  </div>
<?php get_footer(); ?>

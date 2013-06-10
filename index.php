<?php
include_once 'db.php';

$zoom = 20;  // How many pixels per year.
$dateIncrement = 5;  // Which dates are displayed. E.g., if 5, every fifth date is displayed (2010, 2005, ...)
$maxRows = 10;

// Get periods
$prepared = $db->prepare('SELECT * FROM periods ORDER BY period_end_year DESC, period_end_month DESC, period_end_day DESC');
$prepared->execute();
$periods = $prepared->fetchAll();

// Get events
$prepared = $db->prepare('SELECT * FROM events ORDER BY event_year DESC, event_month DESC, event_day DESC');
$prepared->execute();
$events = $prepared->fetchAll();

$startDate = 2010;
$endDate = 1920;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Timeline</title>

<link rel="stylesheet" type="text/css" href="style.css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<!-- <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> -->
<script src="jquery.mousewheel.js"></script>

<script type="text/javascript" src="script.js"></script>

</head>

<body>

<div id="header">
     <a href="/"><h1>Timeline</h1></a>
     <h3>Earth</h3>
     <div style="clear:both;"></div>
</div>


<div id="wrap" class="openhand">
<div id="dates">
<?php
     // Generate date display.
     $yearCount = 0; // multipled by $zoom to get the CSS absolute position, then increment
     for ($i = $startDate; $i >= $endDate; $i-=$dateIncrement) {
          // to provide spacing at the end of timeline
          if ($i < ($endDate + $dateIncrement) ) {
               echo '<div class="date" style="left: ' . $yearCount * $zoom . 'px; padding-right: 65px;"><p>' . $i . '</p></div>';
               break;
          }
          
          echo '<div class="date" style="left: ' . $yearCount * $zoom . 'px;"><p>' . $i . '</p></div>';
          $yearCount += $dateIncrement;
     }
?>
</div>

<div id="content">

<?php
$row = array(); // array_fill(0, $maxRows-1, '')
// $unusedRow = 0;

$lastStart = array_fill(0, $maxRows, -200);  // These two variables will hold the previous block's positions, to check if program can fit in a row. ($lastStart is likely unused)
$lastEnd = array_fill(0, $maxRows, -100);    // Starting value does not matter, as long as it doesn't trigger a move down a row for the first block in the timeline.

foreach($periods as &$period) {
     $period['left'] = (($startDate - $period['period_end_year']) * $zoom) - (($period['period_end_month']-1) * $zoom/12) - (($period['period_end_day']-1) * $zoom/365);
     $period['endBlockLocation'] = (($startDate - $period['period_year']) * $zoom) - (($period['period_month']-1) * $zoom/12) - (($period['period_day']-1) * $zoom/365);
     $period['width'] = $period['endBlockLocation']-$period['left'];
     
     // test for too small block; may need to adjust test value
     if( $period['width'] < 100) $period['width_print'] = 'auto';
     else $period['width_print'] = "${period['width']}px";
     
     
     for( $i = 0; $i < $maxRows; $i++) {
          // Checks to see if the end of the last block extends into current block's space
          if ( $period['left'] > ($lastEnd[$i] + 20) ) {
               // This runs if the space is clear
               $row[$i] = $row[$i] . '<div id="'.$period['period_id'].'" class="item period" style="left: '.$period['left'].'px; width: '.$period['width_print'].';">' 
                          . '<p>' . $period['period_title'].'</p></div>';
               $lastStart[$i] = $period['left'];
               $lastEnd[$i] = $period['endBlockLocation'];
               break;
          }
     }
}
unset($period);


foreach($row as $key => $value) {
     echo '<div id="row'.$key.'" class="rows">';
     echo $value;
     echo '</div>';
}

?>
<!-- <div id="row1" class="rows">
     
     <div id="a" class="item" style="left: 0px; width: 100px;">
     <p>content a</p>
     </div>

     <div id="b" class="item" style="left: 150px; width: 210px;">
     <p>content b</p>
     </div>

     <div id="c" class="item" style="left: 390px; width: 100px;">
     <p>content c</p>
     </div>

     <div id="d" class="item" style="left: 530px; width: 100px;">
     <p>content d</p>
     </div>

     <div id="e" class="item" style="position:absolute; left: 1400px;">
     <p>content e</p>
     </div>
     
     <div style="clear:both;" ></div>
</div> -->



</div>
</div>


<div id="footer">
     <div id="buttons">
          <button class="bttL">Left</button> <button class="bttR">Right</button>
     </div>
     <div style="clear:both;"></div>
</div>


</body>
</html>

<?php

require_once('db.php');

header('Content-Type: application/json');

switch ($_GET['query']) {
    case 'events':
        // if a period is specified, get the events in it. Else get all the events.
        if (isset($_GET['period_id'])) {
            $prepared = $db->prepare('SELECT * FROM events WHERE period_id = :period ORDER BY period_id ASC, event_year DESC, event_month DESC, event_day DESC');
            $prepared->execute( array('period' => $_GET['period_id']) );
        } else {
            $prepared = $db->prepare('SELECT * FROM events ORDER BY period_id ASC, event_year DESC, event_month DESC, event_day DESC');
            $prepared->execute();
        }
        
        $events = $prepared->fetchAll();
        echo json_encode($events);
        break;
    
    case 'periods':
        $prepared = $db->prepare('SELECT * FROM periods ORDER BY period_end_year DESC, period_end_month DESC, period_end_day DESC');
        $prepared->execute();
        $periods = $prepared->fetchAll();
        echo json_encode($periods);
        break;
    
    case 'all':
        $prepared = $db->prepare('SELECT * FROM periods ORDER BY period_end_year DESC, period_end_month DESC, period_end_day DESC');
        $prepared->execute();
        $data = $prepared->fetchAll();
        echo json_encode($data);
        break;

}


?>
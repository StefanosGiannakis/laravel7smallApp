<?php



function formatDatetime(array $dates){
    
    $startDateFormat = new \DateTime($dates['startDate']);
    $endDateFormat = new \DateTime($dates['endDate']);
    
    $dates['startDate'] = $startDateFormat->format('Y-m-d H:i:s');
    $dates['endDate'] = $endDateFormat->format('Y-m-d H:i:s');

    return $dates;
}
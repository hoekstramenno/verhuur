<?php namespace App\ApiHelpers\Date;

use Carbon\Carbon;

class Helper
{

    /**
     * Select a week in the datarange, beginning with a saturday
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function splitInWeeks(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];

        $startDateClone = clone($startDate);

        for ($date = $startDateClone; $date->lte($endDate); $date->addDay()) {
            $tempDate = $date;
            if ($tempDate->isSaturday()) {
                $dates[] = [
                    'start' => $tempDate->toDateString(),
                    'end' => $tempDate->addWeek()->toDateString(),
                ];
                $tempDate->subDay();
            }
        }

        return $dates;
    }

    public function getOnlyTheWeekends(Carbon $startDate, Carbon $endDate)
    {
        $dates = [];

        $startDateClone = clone($startDate);

        for ($date = $startDateClone; $date->lte($endDate); $date->addDay()) {
            if ($date->isSaturday()) {
                $dates[] = [
                    'start' => $date->toDateString(),
                    'end' => $date->addDay()->toDateString(),
                ];
            }
        }
        return $dates;
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param Carbon $targetDate
     * @return bool
     */
    function checkInRange(Carbon $startDate, Carbon $endDate, Carbon $targetDate)
    {
        // Convert to timestamp
        $startDate = $startDate->timestamp;
        $endDate = $endDate->timestamp;
        $targetdate = $targetDate->timestamp;


        // Check that user date is between start & end
        return (($targetdate >= $startDate) && ($targetdate <= $endDate));
    }
}
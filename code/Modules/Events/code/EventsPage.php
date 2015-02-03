<?php

/**
 * Class EventsPage
 */
class EventsPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Events/images/calendar-select.png';

    private static $db = array();

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }

    /**
     * @return bool|string
     *
     * For use in the template
     */
    public function getThisMonthNice(){
        if($calendarDate = Session::get('CalendarDate')){
            $calendarDate = strtotime($calendarDate);
            $date = date('F', $calendarDate);
        } else {
            $date = date('F');
        }
        return $date;
    }

    /**
     * @return bool|string
     */
    private function getThisMonth(){
        if($calendarDate = Session::get('CalendarDate')){
            $calendarDate = strtotime($calendarDate);
            $date = date('m', $calendarDate);
        } else {
            $date = date('m');
        }
        return $date;
    }

    /**
     * @return bool|string
     */
    public function getThisYear(){
        if($calendarDate = Session::get('CalendarDate')){
            $calendarDate = strtotime($calendarDate);
            return date('Y', $calendarDate);
        } else {
            return date('Y');
        }
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return array|bool
     *
     * For use in the DrawCalendar Function
     *
     * returns an array of events that are within the month currently set.
     */
    protected function getEvents($startDate, $endDate) {
        $arrayData = array();
        $events = Event::get()->filter(
            array(
                'Date:GreaterThan' => $startDate,
                'Date:LessThan' => $endDate
            )
        );
        // Check if there are any events, if none return an empty array.
        if ($events->Count() <= 0) {
            return array();
        }
        foreach($events as $key => $data) {
            array_push($arrayData, array(
                'id' => $data->ID,
                'day' => date('d', strtotime($data->Date)),
                'title' => $data->Title
            ));
        }
        return $arrayData;
    }

    /**
     * @param $delay
     * @return string
     *
     * Adds an animation-delay
     */
    private function AnimationDelay($delay) {
        if($delay) {
            $out = 'style="';
            $out.= 'animation-delay: ' . floatval($delay) . 's;';
            $out.= '-webkit-animation-delay: ' . floatval($delay) . 's;';
            $out.= '"';
            return $out;
        }
        return '';
    }

    /**
     * @param $month
     * @param $year
     * @return string
     *
     * Generate the HTML for the calendar
     */
    private function DrawCalendar($month, $year){

        $startDate = (new DateTime())->setDate($year, $month, 1)->format('Y-m-d');

        /**
         * If there's a Session for the date then override the default date (this month/year).
         */
        if($calendarDate = Session::get('CalendarDate')){
            $startDate = $calendarDate;
        }

        /**
         * {$startDateFilter} get the last day of the previous month
         * {$endDateFilter} get the first day of the next month
         *
         * Call the getEvents() method to get all of the events between these two dates.
         */
        $startDateFilter = date('Y-m-t', strtotime("$startDate previous month"));
        $endDateDerpFilter = date('Y-m-01', strtotime("$startDate next month"));
        $events = $this->getEvents($startDateFilter, $endDateDerpFilter);

        /**
         * Initiate calendar HTML
         */
        $calendar = '<div class="calendar-table">';

        /**
         * Headings
         */
        $headings = array('Sun','Mon','Tue','Wed','Thur','Fri','Sat');
        $calendar.= '<div class="calendar-row"><div class="calendar-day-head"><div class="inner">'.implode('</div></div><div class="calendar-day-head"><div class="inner">', $headings).'</div></div></div>';

        /**
         * Days and weeks variables.
         */
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;

        /**
         * First calendar row
         */
        $calendar.= '<div class="calendar-row">';

        /**
         * Variables for css styling
         */
        $animationDelay = 0;
        $animationStep = 0.01;

        /**
         * Start the grid with any empty days that pre-date the starting day of the month
         */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<div class="calendar-day-np" '.$this->AnimationDelay($animationDelay).'><div class="inner">&nbsp;</div></div><!-- /.calendar-day-np -->';
            $animationDelay = $animationDelay + $animationStep;
            $days_in_this_week++;
        endfor;

        /* -----------------------------------------
         * Days
        ------------------------------------------*/

        $eventsToggle = array();

        for($list_day = 1; $list_day <= $days_in_month; $list_day++):

            /**
             * Count the events on this day
             */
            $eventCount = 0;
            $hasEventsClass = ''; // Class to be added to the calendar-day div if there are events.
            $dayEvents = array();
            foreach ($events as $key => $data) {
                if($data['day'] == $list_day) {
                    $eventCount++;
                    $hasEventsClass = ' has-events';
                    array_push($dayEvents, array(
                        'id' => $data['id'],
                        'title' => $data['title']
                    ));
                }
            }
            array_push($eventsToggle, array(
                'id' => $list_day,
                'events' => $dayEvents
            ));

            $calendar.= '<div class="calendar-day'.$hasEventsClass.'" data-show="#events_'.$list_day.'" '.$this->AnimationDelay($animationDelay).'>';
            $calendar.= '<div class="inner">';
            $calendar.= '<div class="day-number">'.$list_day.'</div>';

            $animationDelay = $animationDelay + $animationStep;

            /**
             * If this day has an event or events, display them in the day.
             */
            if ($eventCount === 1) {
                $calendar.= '<div class="events">'.$eventCount.' Event</div>';
            }else if ($eventCount > 1) {
                $calendar.= '<div class="events">'.$eventCount.' Events</div>';
            }

            $calendar.= '</div><!-- /.inner -->';
            $calendar.= '</div><!-- /.calender-day -->';

            /**
             * End the calendar-row, and if there's more dates add another.
             */
            if($running_day == 6):
                $calendar.= '</div><!-- /.calendar-row -->';
                $calendar.= $this->EventsToggle($eventsToggle);
                if(($day_counter+1) != $days_in_month):
                    $eventsToggle = array(); // Reset the $eventsToggle array for the next row.
                    $calendar.= '<div class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /**
         * Finish off the grid with empty days.
         */
        if($days_in_this_week < 8 && $days_in_this_week != 1):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<div class="calendar-day-np" '.$this->AnimationDelay($animationDelay).'><div class="inner">&nbsp;</div></div>';
                $animationDelay = $animationDelay + $animationStep;
            endfor;
        endif;

        $calendar.= '</div><!-- /.calendar-row -->';
        $calendar.= $this->EventsToggle($eventsToggle);
        $calendar.= '</div><!-- /.calendar-table -->';

        return $calendar;
    }

    /**
     * @param $eventsToggle
     * @return string
     *
     * Add Events to a div to be toggled by the user.
     */
    private function EventsToggle($eventsToggle) {
        $out = '';
        foreach($eventsToggle as $key => $data) {
            $out.= '<div id="events_'.$data['id'].'" class="events-toggle">';
            $out.= '<div class="inner">';
            $out.= '<ul>';
            foreach($data['events'] as $event) {
                $out .= '<li><a href="'.$this->Link().'event/'.$event['id'].'">' . $event['title'] . '</a></li>';
            }
            $out.= '</ul>';
            $out.= '</div>';
            $out.= '</div><!-- /.events-toggle -->';
        }
        return $out;
    }

    /**
     * @return string
     */
    public function getCalendar() {
        return $this->DrawCalendar($this->getThisMonth(), $this->getThisYear());
    }

}

/**
 * Class EventsPage_Controller
 */
class EventsPage_Controller extends Page_Controller {

    private static $allowed_actions = array(
        'event',
        'NextMonthForm',
        'PrevMonthForm',
        'CurrentMonthForm'
    );

    public function init(){
        parent::init();
        Requirements::javascript(BOILERPLATE_MODULE.'/code/Modules/Events/javascript/calendar.js');
    }

    /**
     * @param $request
     * @return HTMLText
     *
     * Render the Event DO with the template EventPage
     */
    public function event($request) {
        $id = $request->param('ID');
        /**
         * Check if there's an ID if not, throw a 404 error
         */
        if(!$id){
            $this->httpError(404);
        }
        $event = DataObject::get_by_id('Event', $id);
        /**
         * Check if there is an event with this ID if not, throw a 404 error
         */
        if(!$event){
            $this->httpError(404);
        }
        return $this->customise($event)->renderWith(array('EventPage', 'Page'));
    }

    /**
     * @return mixed
     */
    public function CurrentMonthForm() {
        $action = new FormAction('CurrentMonth', 'Current Month');
        $action->addExtraClass('btn btn-default');
        $actions = new FieldList(
            $action
        );
        $fields = new FieldList();
        $form = Form::create($this, 'CurrentMonthForm', $fields, $actions);

        return $form;
    }

    /**
     * @return mixed
     */
    public function NextMonthForm() {
        $action = new FormAction('NextMonth');
        $action->useButtonTag = true;
        $action->setButtonContent('Next<span class="full"> Month</span>');
        $action->addExtraClass('btn btn-default btn-link btn-sm');
        $actions = new FieldList(
            $action
        );
        $fields = new FieldList();
        $form = Form::create($this, 'NextMonthForm', $fields, $actions);

        return $form;
    }

    /**
     * @return mixed
     */
    public function PrevMonthForm() {
        $action = new FormAction('PrevMonth');
        $action->useButtonTag = true;
        $action->setButtonContent('Previous<span class="full"> Month</span>');
        $action->addExtraClass('btn btn-default btn-link btn-sm');
        $actions = new FieldList(
            $action
        );
        $fields = new FieldList();
        $form = Form::create($this, 'PrevMonthForm', $fields, $actions);

        return $form;
    }

    /**
     * @return SS_HTTPResponse
     *
     * Add/Subtract from the current month set in the CalendarDate, or if no direction is set clear the session.
     */
    public function ChangeMonth($direction = null) {

        /**
         * Set variable to add, or subtract months from the calendar date. If no parameter set, clear the session and return to the page.
         */
        if($direction == 'prev') {
            $change = '-1';
        } else if($direction == 'next'){
            $change = '+1';
        } else {
            Session::clear('CalendarDate');
            return $this->redirect($this->Link());
        }

        /**
         * If there is a session set th calendar date to {$change}, or set the session to the current month.
         */
        if($sessionDate = Session::get('CalendarDate')){
            Session::set('CalendarDate', date('Y-m-d', strtotime($change.' month', strtotime($sessionDate))));
        } else {
            $now = date('Y-m-01', strtotime($change.' month'));
            Session::set('CalendarDate', $now);
        }
        return $this->redirect($this->Link());
    }

    /**
     * Reset the session data and display the current month
     */
    public function CurrentMonth(){
        $this->ChangeMonth();
    }

    /**
     * Add to the current {CalendarDate} session and display the next month.
     */
    public function NextMonth(){
        $this->ChangeMonth('next');
    }

    /**
     * Subtract from the current {CalendarDate} session and display the previous month.
     */
    public function PrevMonth(){
        $this->ChangeMonth('prev');
    }

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;

class GoogleCalendarController extends Controller
{
    private function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Google Calendar API Integration');
        $client->setAuthConfig(public_path('uploads/my-calendar-integration-475507-bcebaaa3a542.json'));
        $client->addScope(Calendar::CALENDAR);
        // $client->setSubject('abdul.rauf.pakistan.work@gmail.com'); // <-- your own email
        return $client;
    }

    public function getAvailableTimes(Request $request, $date)
    {
        $date = $date;
        if (!$date) {
            return response()->json(['error' => 'Date is required'], 400);
        }

        $client = $this->getClient();
        $service = new Calendar($client);

        $startOfDay = $date . 'T00:00:00Z';
        $endOfDay = $date . 'T23:59:59Z';
        $calendarId = 'abdul.rauf.pakistan.work@gmail.com';
        $events = $service->events->listEvents($calendarId, [
            'timeMin' => $startOfDay,
            'timeMax' => $endOfDay,
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ]);

        Log::info('Fetched events:', ['count' => count($events->getItems())]);
        foreach ($events->getItems() as $e) {
            Log::info('Event', [
                'summary' => $e->getSummary(),
                'start' => $e->start->dateTime ?: $e->start->date,
                'end' => $e->end->dateTime ?: $e->end->date,
            ]);
        }

        $busySlots = [];
        foreach ($events->getItems() as $event) {
            $busySlots[] = [
                'start' => $event->start->dateTime ?: $event->start->date,
                'end' => $event->end->dateTime ?: $event->end->date,
            ];
        }
        Log::info($busySlots);

        // Example working hours: 9 AM to 5 PM
        $availableSlots = [];
        $startHour = 9;
        $endHour = 17;

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $slotStart = "{$date}T" . str_pad($hour, 2, '0', STR_PAD_LEFT) . ":00:00Z";
            $slotEnd = "{$date}T" . str_pad($hour + 1, 2, '0', STR_PAD_LEFT) . ":00:00Z";

            $conflict = false;
            foreach ($busySlots as $busy) {
                if (($slotStart < $busy['end']) && ($slotEnd > $busy['start'])) {
                    $conflict = true;
                    break;
                }
            }

            if (!$conflict) {
                $availableSlots[] = date('h:i A', strtotime($slotStart));
            }
        }

        return response()->json([
            'date' => $date,
            'available_times' => $availableSlots,
        ]);
    }
}

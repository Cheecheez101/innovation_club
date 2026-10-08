<?php
require_once 'app/core/App.php';
require_once 'app/models/Event.php';

try {
    $eventModel = new Event();

    // Test getting all events
    $events = $eventModel->getAllEvents();
    echo "Found " . count($events) . " events\n";

    // Test creating a new event
    $testEvent = [
        'title' => 'Test Event',
        'description' => 'This is a test event',
        'event_type' => 'meeting',
        'event_date' => '2024-12-25',
        'event_time' => '10:00:00',
        'duration' => '2 hours',
        'location' => 'Main Hall',
        'capacity' => 50,
        'venue_details' => 'First floor, room 101',
        'organizer' => 'Test Organizer',
        'contact_email' => 'test@example.com',
        'registration_deadline' => '2024-12-20',
        'cost' => 0.00,
        'is_public' => 1,
        'allow_registration' => 1,
        'created_by' => 1,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $result = $eventModel->createEvent($testEvent);
    if ($result) {
        echo "Test event created successfully\n";
    } else {
        echo "Failed to create test event\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
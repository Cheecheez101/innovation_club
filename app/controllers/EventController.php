<?php
class EventController extends Controller {
    private $eventModel;

    public function __construct() {
        require_once APP_PATH . '/models/Event.php';
        $this->eventModel = new Event();
    }
    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $data = [
            'title' => 'Events - ' . APP_NAME,
            'events' => $this->eventModel->getAllEvents()
        ];

        $this->view('events/index', $data);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Only admins and patrons can create events
        if ($userRole === 'member') {
            $_SESSION['error'] = 'You do not have permission to create events.';
            $this->redirect('events');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'event_type' => trim($_POST['event_type']),
                'event_date' => trim($_POST['event_date']),
                'start_time' => trim($_POST['event_time']),
                'end_time' => null,
                'duration' => trim($_POST['duration']) ?: null,
                'location' => trim($_POST['location']),
                'capacity' => trim($_POST['capacity']) ?: null,
                'venue_details' => trim($_POST['venue_details']) ?: null,
                'organizer' => trim($_POST['organizer']) ?: null,
                'contact_email' => trim($_POST['contact_email']) ?: null,
                'registration_deadline' => trim($_POST['registration_deadline']) ?: null,
                'cost' => trim($_POST['cost']) ?: 0,
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'allow_registration' => isset($_POST['allow_registration']) ? 1 : 0,
                'created_by' => $_SESSION['user_id'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->eventModel->createEvent($eventData)) {
                $_SESSION['success'] = 'Event created successfully!';
                $this->redirect('events');
            } else {
                $_SESSION['error'] = 'Failed to create event. Please try again.';
                $data = [
                    'title' => 'Create Event - ' . APP_NAME,
                    'event' => $eventData
                ];
                $this->view('events/create', $data);
            }
        } else {
            $data = [
                'title' => 'Create Event - ' . APP_NAME
            ];
            $this->view('events/create', $data);
        }
    }

    public function edit($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Only admins and patrons can edit events
        if ($userRole === 'member') {
            $_SESSION['error'] = 'You do not have permission to edit events.';
            $this->redirect('events');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        $data = [
            'title' => 'Edit Event - ' . APP_NAME,
            'event' => $this->eventModel->getEventById($id)
        ];

        $this->view('events/edit', $data);
    }

    public function update($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Only admins and patrons can update events
        if ($userRole === 'member') {
            $_SESSION['error'] = 'You do not have permission to update events.';
            $this->redirect('events');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'event_type' => trim($_POST['event_type']),
                'event_date' => trim($_POST['event_date']),
                'start_time' => trim($_POST['event_time']),
                'end_time' => null,
                'duration' => trim($_POST['duration']) ?: null,
                'location' => trim($_POST['location']),
                'capacity' => trim($_POST['capacity']) ?: null,
                'venue_details' => trim($_POST['venue_details']) ?: null,
                'organizer' => trim($_POST['organizer']) ?: null,
                'contact_email' => trim($_POST['contact_email']) ?: null,
                'registration_deadline' => trim($_POST['registration_deadline']) ?: null,
                'cost' => trim($_POST['cost']) ?: 0,
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'allow_registration' => isset($_POST['allow_registration']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->eventModel->updateEvent($id, $eventData)) {
                $_SESSION['success'] = 'Event updated successfully!';
                $this->redirect('events/view/' . $id);
            } else {
                $_SESSION['error'] = 'Failed to update event. Please try again.';
                $data = [
                    'title' => 'Edit Event - ' . APP_NAME,
                    'event' => array_merge($this->eventModel->getEventById($id), $eventData)
                ];
                $this->view('events/edit', $data);
            }
        } else {
            $this->redirect('events/edit/' . $id);
        }
    }

    public function show($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            $_SESSION['error'] = 'Event not found.';
            $this->redirect('events');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Add registration information for members
        if ($userRole === 'member') {
            $event['is_registered'] = $this->eventModel->isUserRegistered($id, $_SESSION['user_id']);
        }

        $event['registered_count'] = $this->eventModel->getRegistrationCount($id);

        // Add attendees list for admins/patrons
        if ($userRole !== 'member') {
            $event['attendees'] = $this->eventModel->getEventRegistrations($id);
        }

        $data = [
            'title' => 'View Event - ' . APP_NAME,
            'event' => $event,
            'userRole' => $userRole
        ];

        $this->view('events/view', $data);
    }

    public function register($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Only members can register for events (admins and patrons don't need to register)
        if ($userRole !== 'member') {
            $_SESSION['error'] = 'Only members can register for events.';
            $this->redirect('events/view/' . $id);
            return;
        }

        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            $_SESSION['error'] = 'Event not found.';
            $this->redirect('events');
            return;
        }

        // Check if registration is allowed (default true for legacy schema)
        $allowRegistration = $event['allow_registration'] ?? true;
        if (!$allowRegistration) {
            $_SESSION['error'] = 'Registration is not open for this event.';
            $this->redirect('events/view/' . $id);
            return;
        }

        // Registration is allowed only for events that are not finished/cancelled.
        $eventStatus = strtolower((string)($event['status'] ?? 'scheduled'));
        if (!in_array($eventStatus, ['upcoming', 'scheduled'], true)) {
            $_SESSION['error'] = 'Registration is only available for upcoming events.';
            $this->redirect('events/view/' . $id);
            return;
        }

        // Check if user is already registered
        if ($this->eventModel->isUserRegistered($id, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'You are already registered for this event.';
            $this->redirect('events/view/' . $id);
            return;
        }

        // Check capacity (fall back to legacy max_participants)
        $capacity = $event['capacity'] ?? ($event['max_participants'] ?? null);
        if ($capacity && $this->eventModel->getRegistrationCount($id) >= $capacity) {
            $_SESSION['error'] = 'Event is at full capacity.';
            $this->redirect('events/view/' . $id);
            return;
        }

        // Register the user
        $registrationData = [
            'event_id' => $id,
            'user_id' => $_SESSION['user_id'], // The model will convert this to member_id
            'registered_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventModel->registerForEvent($registrationData)) {
            $_SESSION['success'] = 'Successfully registered for the event!';
        } else {
            $_SESSION['error'] = 'Failed to register for the event. Please try again.';
        }

        $this->redirect('events/view/' . $id);
    }

    public function unregister($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';

        // Only members can unregister from events
        if ($userRole !== 'member') {
            $_SESSION['error'] = 'Only members can unregister from events.';
            $this->redirect('events/view/' . $id);
            return;
        }

        if ($this->eventModel->unregisterFromEvent($id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Successfully unregistered from the event.';
        } else {
            $_SESSION['error'] = 'Failed to unregister from the event.';
        }

        $this->redirect('events/view/' . $id);
    }

    public function delete($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if (!$id) {
            $this->redirect('events');
            return;
        }

        $userRole = $_SESSION['role'] ?? 'member';
        if ($userRole === 'member') {
            $_SESSION['error'] = 'You do not have permission to delete events.';
            $this->redirect('events/view/' . $id);
            return;
        }

        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            $_SESSION['error'] = 'Event not found.';
            $this->redirect('events');
            return;
        }

        if ($this->eventModel->deleteEvent($id)) {
            $_SESSION['success'] = 'Event deleted successfully!';
            $this->redirect('events');
            return;
        }

        $_SESSION['error'] = 'Failed to delete event. Please try again.';
        $this->redirect('events/view/' . $id);
    }
}
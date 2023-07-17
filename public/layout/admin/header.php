<?php
    $complaintNotificationNotifications = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints WHERE EXISTS(SELECT * FROM complaint_descriptions WHERE complaints.id = complaint_descriptions.complaint_id) AND is_read = 0 ORDER BY created_at DESC")->fetchAll();
    $bookingNotificationIdNotifications = array_column($complaintNotificationNotifications, 'booking_id');

    $bookingNotificationNotifications = $roomNotificationNotifications = $userNotificationNotifications = [];

    if (count($bookingNotificationIdNotifications) > 0) {
        $bookingNotificationIdNotifications = join(',', $bookingNotificationIdNotifications);

        $bookingNotificationNotifications   = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE bookings.id IN ({$bookingNotificationIdNotifications})")->fetchAll();

        $roomNotificationIdNotifications = join(',', array_column($bookingNotificationNotifications, 'room_id'));
        $roomNotificationNotifications = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE rooms.id IN ({$roomNotificationIdNotifications})")->fetchAll();

        $userNotificationIdNotifications = join(',', array_column($bookingNotificationNotifications, 'user_id'));
        $userNotificationNotifications = \App\Models\User::instance()->raw("SELECT * FROM users WHERE users.id IN ({$userNotificationIdNotifications})")->fetchAll();
    }
?>
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi</div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <?php foreach ($complaintNotificationNotifications as $complaintNotification): ?>

                        <?php
                            $roomNotification = array_filter($roomNotificationNotifications, function ($roomNotification) use ($complaintNotification) {
                                return $roomNotification['id'] == $complaintNotification['room_id'];
                            });

                            $bookingNotification = array_filter($bookingNotificationNotifications, function ($bookingNotification) use ($complaintNotification) {
                                return $bookingNotification['id'] == $complaintNotification['booking_id'];
                            });

                            $bookingNotification = reset($bookingNotification);

                            $userNotification = array_filter($userNotificationNotifications, function ($userNotification) use ($bookingNotification) {
                                return $userNotification['id'] == $bookingNotification['user_id'];
                            });

                            $roomNotification    = reset($roomNotification);
                            $userNotification    = reset($userNotification);
                        ?>

                        <a href="<?= route('admin.complaints.show') . '?' . http_build_query(['booking_id' => $bookingNotification['id'], 'room_id' => $bookingNotification['room_id'], 'complaint_id' => $complaintNotification['id']]); ?>" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                <b><?= $userNotification['name']; ?></b> mengajukan komplain untuk kamar <b><?= $roomNotification['room_number']; ?>&nbsp;&nbsp;<span class="badge badge-primary text text-small py-1 px-2">new!</span></b>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?= asset('assets/img/avatar/avatar-1.png'); ?>" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, <?= \Lib\Session\Session::get('user')['name']; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="<?= route('auth.logout'); ?>" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
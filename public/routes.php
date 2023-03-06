<?php

return [
    "home.index" => "index.php",
    "auth.logout" => "actions/auth/auth_logout.php",
    "auth.login.index" => "login.php",
    "auth.login.store" => "actions/auth/auth_login.php",

    "customers.profile.index" => "customer/biodata.php",
    "customers.profile.store" => "actions/customer/biodata_update.php",
    "customers.profile.password.store" => "actions/customer/password_update.php",

    "customers.orders.index" => "customer/order.php",
    "customers.orders.complaints.index" => "customer/complaint.php",
    "customers.orders.complaints.store" => "actions/customer/complaint_store.php",

    "customer.orders.update.cancel" => "actions/customer/order_update_cancel.php",

    "rooms.detail" => "customer/room_detail.php",
    "rooms.bookings.store" => "actions/customer/room_store.php",

    "admin.dashboard.index" => "admin/dashboard.php",
    "admin.rooms.index" => "admin/room.php",
    "admin.rooms.form" => "admin/room_form.php",
    "admin.rooms.store" => "actions/admin/room_store.php",
    "admin.rooms.update" => "actions/admin/room_update.php",
    "admin.rooms.destroy" => "actions/admin/room_destroy.php",

    "admin.rooms.facilities.index" => "admin/facility.php",
    "admin.rooms.facilities.form" => "admin/facility_form.php",
    "admin.rooms.facilities.store" => "actions/admin/facility_store.php",
    "admin.rooms.facilities.update" => "actions/admin/facility_update.php",
    "admin.rooms.facilities.destroy" => "actions/admin/facility_destroy.php",

    "admin.rooms.galleries.index" => "admin/gallery.php",
    "admin.rooms.galleries.form" => "admin/gallery_form.php",
    "admin.rooms.galleries.store" => "actions/admin/gallery_store.php",
    "admin.rooms.galleries.update" => "actions/admin/gallery_update.php",
    "admin.rooms.galleries.destroy" => "actions/admin/gallery_destroy.php",

    "admin.orders.index" => "admin/order.php",
    "admin.orders.update" => "actions/admin/order_update.php",

    "admin.complaints.index" => "admin/complaint.php",
    "admin.complaints.show" => "admin/complaint_form.php",
    "admin.complaints.update" => "actions/admin/complaint_update.php",

    "admin.reports.incomes.index" => "admin/reports/income.php",
    "admin.reports.incomes.print.index" => "admin/reports/income_print.php",
];
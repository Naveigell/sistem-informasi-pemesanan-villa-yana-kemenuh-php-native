<!-- General CSS Files -->
<link rel="stylesheet" href="../../assets/modules/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/modules/fontawesome/css/all.min.css">

<!-- CSS Libraries -->

<!-- Template CSS -->
<link rel="stylesheet" href="../../assets/css/style.css">
<link rel="stylesheet" href="../../assets/css/components.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<style>
    .main-content {
        padding-top: 100px !important;
    }
</style>

<script>
    function createCountDown(time, target, callback) {
        // Set the date we're counting down to
        var countDownDate = new Date(time).getTime();

        // Update the count-down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count-down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            target.innerHTML = days + " hari " + hours + " jam "
                + minutes + " menit " + seconds + " detik ";

            // If the count-down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                target.innerHTML = "EXPIRED";

                callback(true);
            } else {
                callback(false);
            }
        }, 1000);
    }

</script>
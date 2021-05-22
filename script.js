$(document).ready(function () {

    //Set current year for copyright
    $('#latestYear').text(new Date().getFullYear());

    //Trigger whatsapp button event
    $('.whatsappLink').on('click', function () {

        //If current device is on mobile, redirect to mobile based url, otherwise redirect to desktop based url
        if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
            window.open(
                "https://wa.me/+60126113810?text=I want to know more about Attendance System.",
                "_blank");
        } else {
            window.open(
                "https://web.whatsapp.com/send?phone=%2B60126113810&text=I want to know more about Attendance System.&app_absent=0",
                "_blank");
        }
    });
})
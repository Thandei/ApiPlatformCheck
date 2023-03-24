// ----- COMING SOON TEMPLATE SCRIPTS & STYLESHEETS ----- //

// Stylesheets
import '../theme/creasoon/fonts/font-awesome.css';
import '../theme/creasoon/fonts/elegant-fonts.css';
import '../theme/creasoon/bootstrap/css/bootstrap.css';
import '../theme/creasoon/css/magnific-popup.css';
import '../theme/creasoon/css/style.css';

// Scripts
import 'jquery/dist/jquery';
import 'bootstrap/dist/js/bootstrap';
import '../theme/creasoon/js/jquery.validate.min';
import '../theme/creasoon/js/jquery.magnific-popup.min';
import '../theme/creasoon/js/jquery.plugin.min';
import '../theme/creasoon/js/jquery.countdown.min';
import Sketch from 'sketch-js/js/sketch';

$(function () {

    // REMOVE SYMFONY DEBUG TOOLBAR
    setTimeout(function () {
        $('.sf-minitoolbar').remove();
        console.log("Symfony Toolbar Removed");
    }, 3000);



    // ANIMATE
    $("[data-background-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-background-color"));
    });

    $(".bg-transfer").each(function () {
        $(this).css("background-image", "url(" + $(this).find("img").attr("src") + ")");
    });

    $(".animate").each(function (e) {
        var $this = $(this);
        setTimeout(function () {
            $this.addClass("idle");
        }, e * 100);
    });


    const cdSelector = $(".count-down");
    if (cdSelector.length) {
        var year = parseInt(cdSelector.attr("data-countdown-year"), 10);
        var month = parseInt(cdSelector.attr("data-countdown-month"), 10) - 1;
        var day = parseInt(cdSelector.attr("data-countdown-day"), 10);
        cdSelector.countdown({until: new Date(year, month, day), padZeroes: true});
    }


    // BACKGROUND SKETCH
    var COLOURS = ['#61dfff', '#A7EBCA', '#FFFFFF', '#ff6767', '#61dfff'];
    var radius = 0;
    var randomColor = 0;

    Sketch.create({

        container: document.getElementById('background-content'),
        autoclear: false,
        retina: 'auto',

        update: function () {
            radius = 2 + abs(sin(this.millis * 0.003) * 50);
        },

        click: function () {
            randomColor = parseInt((COLOURS.length) * Math.random(), 10);
        },

        touchmove: function () {

            for (var i = this.touches.length - 1, touch; i >= 0; i--) {

                touch = this.touches[i];

                this.lineCap = 'round';
                this.lineJoin = 'round';
                this.fillStyle = this.strokeStyle = COLOURS[randomColor % COLOURS.length];
                this.lineWidth = radius;

                this.beginPath();
                this.moveTo(touch.ox, touch.oy);
                this.lineTo(touch.x, touch.y);
                this.stroke();
            }
        }
    });

});


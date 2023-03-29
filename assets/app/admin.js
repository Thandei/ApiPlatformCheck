// ----- ADMIN TEMPLATE SCRIPTS & STYLESHEETS ----- //


// ----- STYLESHEET AND FONTS ----- //
import '../theme/ablepro/fonts/inter/inter.css';
import '../theme/ablepro/fonts/tabler-icons.min.css';
import '../theme/ablepro/fonts/material.css';
import 'font-awesome/css/font-awesome.css';
import 'feather-icons/dist/feather';
import '../theme/ablepro/scss/style.scss';
import '../theme/ablepro/scss/style-preset.scss';


// ----- SCRIPTS ----- //
import '@popperjs/core';
import 'simplebar';
import 'bootstrap';
import '../theme/ablepro/js/fonts/custom-font.js'
import '../theme/ablepro/js/pcoded';
import 'feather-icons';

// ----- SCRIPTS ----- //

// Swagger UI - Depreced
import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

// Notifier
import notifier from 'notifier-js/js/notifier';
import 'notifier-js/css/notifier.css';

var adminPagesGlobalInitializer = function () {

    // General Config
    const pageMessageDismissDelay = 5000;

    const swaggerURL = 'admin/documentation/swagger/json';

    var _initSwaggerUI = function () {
        SwaggerUI({
            dom_id: '#docsSwagger',
            url: window.location.origin + "/" + swaggerURL,
        })
    }

    var _initNotifications = function () {

        $(".showNotifierSuccess").each(function () {
            notifier.show('Success!', $(this).val(), 'success', '', pageMessageDismissDelay);
        });

        $(".showNotifierError").each(function () {
            notifier.show('Sorry!', $(this).val(), 'danger', '', pageMessageDismissDelay);
        });

    }

    return {
        init: function () {
            // _initSwaggerUI();
            _initNotifications();
        }
    }

};

document.addEventListener("DOMContentLoaded", function () {
    adminPagesGlobalInitializer().init();
});

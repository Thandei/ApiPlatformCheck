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

// OTHERS
import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

var adminPagesGlobalInitializer = function () {

    const swaggerURL = 'admin/documentation/swagger/json';

    var _initSwaggerUI = function () {

        SwaggerUI({
            dom_id: '#docsSwagger',
            url: window.location.origin + "/" + swaggerURL,
        })

    }

    return {
        init: function () {
            _initSwaggerUI();
        }
    }

};

document.addEventListener("DOMContentLoaded", function () {
    adminPagesGlobalInitializer().init();
});

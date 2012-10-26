'use strict';

var lccApp = angular.module('lccApp', [])
    .config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'views/main.html'
        })
        .when('/roster', {
            templateUrl: 'views/roster.html',
            controller: 'RosterCtrl'
        })
        .when('/about', {
            templateUrl: 'views/about.html'
        })
        .when('/contact', {
            templateUrl: 'views/contact.html'
        })
        .when('/calendar', {
            templateUrl: 'views/calendar.html'
        })
        .otherwise({
            redirectTo: '/'
        });
}]);

lccApp.run(function($rootScope) {
    $rootScope.loginForm = {
        config: {
            speed: 300,
            effect: 'slideToggle'
        },

        init: function(config) {
            jQuery.extend(this.config, config);

            this.config.$form.on('submit', this.submit).hide();
        },

        toggle: function() {
            var config = $rootScope.loginForm.config,
                $form = $rootScope.loginForm.config.$form;
            $form[config.effect](config.speed); //Execute the effect
            $rootScope.loginForm.config.$openButton.fadeToggle(config.speed);
            $rootScope.loginForm.config.$closeButton.fadeToggle(config.speed);
            $rootScope.loginForm.config.$errorDiv.fadeOut(config.speed);
        },

        submit: function(e) {
            var $form = jQuery(this);
            e.preventDefault();

            //If supported, the browser will enforce our "required attributes", so this code will never execute
            if (!Modernizr.input.required) {
                jQuery('input[required]', $form).each(function() {
                    jQuery(this).removeAttr('required').addClass("required " + this.getAttribute('type'));
                });
                $form.validate();
            }

            jQuery.post('/recordings.php', $form.serialize(), function(response) {
                if (response.length < 2) {
                    window.location.href = '/calendar.php';
                } else {
                    //TODO use noty
                    $rootScope.loginForm.config.$errorDiv.html(response).slideDown(300);
                }
            });
        }
    };

    $rootScope.$on('$viewContentLoaded', function() {
        $rootScope.loginForm.init({
            $form: $('#login-win'),
            $openButton: $('#login-open'),
            $closeButton: $('#login-close')
        });
    });
});

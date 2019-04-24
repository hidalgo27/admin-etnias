
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import Swal from 'sweetalert2';
window.Swal = require('sweetalert2');

// window.grunt = require('grunt');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
$('.datepicker').datepicker();
$(document).ready(function (){
    // $('.descripcion').summernote({
    //     height: 150,   //set editable area's height
    //     codemirror: { // codemirror options
    //         theme: 'monokai'
    //  }
    // });

       tinymce.init({
        selector: "textarea",
        height: 300,
        menubar: false,
        plugins: [
            'advlist lists'
        //   'advlist autolink lists link image charmap print preview anchor textcolor',
        //   'searchreplace visualblocks code fullscreen',
        //   'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
       '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
       '//www.tiny.cloud/css/codepen.min.css'
        ],
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
      });

    $('[data-tooltip="popover"]').popover({ trigger: "hover" });
});


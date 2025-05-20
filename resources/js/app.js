import './bootstrap';
import $ from 'jquery';

import 'select2';
import 'select2/dist/css/select2.min.css';
import select2 from 'select2';

import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

window.$ = $;
window.jQuery = $;

select2(window.jQuery);

window.DataTable = DataTable;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

window.onbeforeunload = function () {
    console.log("Navigating away...");
};
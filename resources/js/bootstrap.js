window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}
window.axios = require('axios');

var token = localStorage.getItem('b2c-user-token');
window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
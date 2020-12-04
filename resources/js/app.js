
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
require('./bootstrap')
// window.Vue = require('vue');
// import Swal from 'sweetalert2';
// window.Swal = Swal;
// require('./components/App')
// const swal = window.swal = require('sweetalert2');
// Vue.use(VueRouter)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('x-component', require(''));
// Vue.component('example-component', require('./views/ExampleComponent.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );

// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );

// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );


// import App from './views/App.vue';
// import Welcome from './views/welcome-vue'

// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/',
//             name: 'home',
//             component: Welcome
//         },
//     ],
// });
// import router from './router';
// import App from './views/App';
// Vue.config.productionTip = false

// new Vue({
//     el: '#app',
//     components: { App },
//     template: '<App/>',
//     router,               // <-- register router with Vue
//     render: (h) => h(App) // <-- render App component
// });

// import Vue from 'vue'
// import App from './views/App'
// import VueSentry from 'vue2-sentry'

// Vue.use(VueSentry, {
//   key: '64f25e71c2d348f1bf4ac164c25a721e',
//   project: '1354748',
//   config: {} // Optional: custom config
// })

// Vue.config.productionTip = false
// Vue.config.devtools = false;
// Vue.config.debug = false;
// Vue.config.silent = true; 
// Vue.config.devtools = false
// Vue.config.debug = falsep
// Vue.config.silent = true

/* eslint-disable no-new */
// new Vue({
//   el: '#app',
//   render: h => h(App),
// }).$mount('#app');

var path = require('path');

module.exports = {
  entry: 'index',
  output: {
    path: path.join(__dirname, 'scripts'),
    filename: 'bundle.js'
  },
  module: {
    loaders: [
      { test: /\.json$/, loader: 'json-loader' }
    ]
  },
  resolve: {
    extensions: ['', '.webpack.mix.js','webpack.js', '.web.js', '.js']
  },
  node: {
    console: 'empty',
    fs: 'empty',
    net: 'empty',
    tls: 'empty'
  }
};
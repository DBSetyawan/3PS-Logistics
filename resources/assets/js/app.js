
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// import Vue from 'vue'
// import VueRouter from 'vue-router'

// window.Vue = require('vue');
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

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// import App from './views/App'
// import Welcome from './views/Welcome'

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

// // const app = new Vue({
// //     el: '#app'
// // });
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

// const app = new Vue({
//     el: '#app',
//     components: { App },
//     router
// });

// import Vue from 'vue'
// import App from './components/views/App.vue'
// import VueSentry from 'vue2-sentry'

// Vue.config.devtools = false;
// Vue.config.debug = false;
// Vue.config.silent = true; 

// Vue.use(VueSentry, {
//   key: '64f25e71c2d348f1bf4ac164c25a721e',
//   project: '1354748',
//   config: {} // Optional: custom config
// })

// Vue.config.productionTip = false

/* eslint-disable no-new */
// new Vue({
//   el: '#app',
//   render: h => h(App)
// })
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import Header from './Header'
import NewProject from './NewProject'
import ProjectsList from './ProjectsList'
import SingleProject from './SingleProject'
class App extends Component {
  render () {
    return (
      <BrowserRouter>
        <div>
          <Header />
          <Switch>
            <Route exact path='/' component={ProjectsList} />
            <Route path='/create' component={NewProject} />
            <Route path='/:id' component={SingleProject} />
          </Switch>
        </div>
      </BrowserRouter>
    )
  }
}

ReactDOM.render(<App />, document.getElementById('app'))

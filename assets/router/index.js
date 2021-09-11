import { createApp, createWebHashHistory } from 'vue'
import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import CodeCreation from '../components/CodeCreation'
import CodeDeletion from '../components/CodeDeletion'
import { isLoggedIn } from '../utils/index.js'

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
  { path: '/', component: Home },
  { path: '/new', component: CodeCreation },
  { path: '/delete', component: CodeDeletion },
  { path: '/login', component: Login, name:'login', meta: {
    allowAnonymous: true
  } },
  { path:'/register', component: Register, meta: {
    allowAnonymous: true
  }}
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
  // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
  history: createWebHistory(process.env.BASE_URL),
  routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
  
  if (to.name == 'login' && isLoggedIn()) {
    next({ path: '/' })
  }
  else if (!to.meta.allowAnonymous && !isLoggedIn()) {
    next({
      path: '/login',
      query: { redirect: to.fullPath }
    })
  }
  else {
    next()
  }  
})
export default router;
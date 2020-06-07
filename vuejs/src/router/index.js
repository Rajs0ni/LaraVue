import Vue from 'vue';
import VueRouter from 'vue-router';
import paths from './paths';
import store from '@/store';
import DEFINES from '@/defines';

Vue.use (VueRouter);

const router = new VueRouter ({
  mode: 'history',
  base: '/',
  linkActiveClass: 'active',
  routes: paths,
});

router.beforeEach (async (to, from, next) => {
  //  Layout to be used
  let currentLayout = store.getters['app/appLayout'];
  let expectedLayout = to.meta.layout || DEFINES.LAYOUT_AUTH;
  if (currentLayout != expectedLayout) {
    store.dispatch (
      'app/setAppLayout',
      {layout: expectedLayout},
      DEFINES.USE_ROOT
    );
  }

  if (store.getters['app/isLoggedIn'] && to.path.startsWith ('/guest')) {
    return next ({name: 'member.tasks'});
  }

  //Check for authentication
  if (!store.getters['app/isLoggedIn'] && !to.meta.public) {
    return next ({
      name: 'guest.login',
      query: {
        redirect: to.fullPath,
      },
    });
  }
  next ();
});

export default router;

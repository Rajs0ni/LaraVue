import DEFINES from '@/defines';
const lazyLoadPage = (directory, page) => () =>
  import (`@/pages/${directory}/${page}.vue`);

export default [
  {
    path: '/',
    redirect: '/guest/login',
    name: 'RootPath',
    meta: {
      layout: DEFINES.LAYOUT_AUTH,
      public: true,
    },
  },
  // Guest
  {
    path: '/guest',
    name: 'GuestRoot',
    meta: {
      layout: DEFINES.LAYOUT_AUTH,
      public: true,
    },
    component: lazyLoadPage ('guest', 'GuestRoot'),
    children: [
      {
        path: 'login',
        name: 'guest.login',
        component: lazyLoadPage ('guest/auth', 'Login'),
        meta: {
          layout: DEFINES.LAYOUT_AUTH,
          public: true,
        },
      },
      {
        path: 'register',
        name: 'guest.register',
        component: lazyLoadPage ('guest/auth', 'Register'),
        meta: {
          layout: DEFINES.LAYOUT_AUTH,
          public: true,
        },
      },
    ],
  },

  // Member
  {
    path: '/app',
    redirect: '/app/tasks',
    name: 'MemberRoot',
    meta: {
      layout: DEFINES.LAYOUT_APP,
    },
    component: lazyLoadPage ('member', 'MemberRoot'),
    children: [
      {
        path: 'tasks',
        name: 'member.tasks',
        component: lazyLoadPage ('member/task', 'List'),
        meta: {
          layout: DEFINES.LAYOUT_APP,
        },
      },
    ],
  },
];

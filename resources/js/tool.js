Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-scheduler-ui',
      path: '/nova-scheduler-ui',
      component: require('./components/Tool'),
    },
  ])
})

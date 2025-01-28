import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from './Layouts/Layout.vue'

import 'bootstrap/dist/js/bootstrap.bundle.js'
import 'remixicon/fonts/remixicon.css'
import '../css/custom.scss'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    const page = pages[`./Pages/${name}.vue`];

    page.default.layout = page.default.layout || Layout;

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
// Components
import App from "./App.vue";

// Composables
import { createApp } from "vue";

// Router
import router from "./router/index";

// Plugins
import { registerPlugins } from "@/plugins";

const app = createApp(App);

registerPlugins(app);

app.use(router);

app.mount("#app");

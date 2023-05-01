import { createStore } from "vuex";
import common from "./common";

const store = createStore({
  modules: {
    common,
  },
});

export default store;

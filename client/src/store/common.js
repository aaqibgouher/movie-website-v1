import {
  addFavouriteApi,
  getFavouritesApi,
  getMovieByIMDBIdApi,
  getMoviesApi,
  getSimilarMoviesApi,
  loginApi,
  logoutApi,
  registerApi,
  removeFavouriteApi,
} from "@/helpers/Helper";
import router from "@/router";

const state = {
  movies: [],
  total: 0,
  error: "",
  movie: {},
  similar: {},
  user: {},
  isLogin: false,
  show: false,
  color: "",
  text: "",
};

const mutations = {
  SET_MOVIES(state, data) {
    state.movies = data;
  },
  SET_TOTAL(state, data) {
    state.total = data;
  },
  SET_ERROR(state, data) {
    state.error = data;
  },
  SET_MOVIE(state, data) {
    state.movie = data;
  },
  SET_SIMILAR(state, data) {
    state.similar = data;
  },
  SET_USER(state, data) {
    state.user = data;
  },
  SET_IS_LOGIN(state, data) {
    state.isLogin = data;
  },
  SET_SHOW(state, data) {
    state.show = data;
  },
  SET_COLOR(state, data) {
    state.color = data;
  },
  SET_TEXT(state, data) {
    state.text = data;
  },
};

const actions = {
  async getAllMovies({ commit }, payload) {
    console.log(payload, "from common store");
    const res = await getMoviesApi(payload);

    console.log(res, "from res");
    if (
      "status" in res &&
      res.data.status === 200 &&
      res.data.data.Response === "True"
    ) {
      console.log(res.data.data.Search, "from search");
      commit("SET_MOVIES", res.data.data.Search);
      commit("SET_TOTAL", res.data.data.totalResults);
    } else {
      commit("SET_MOVIES", []);
      commit("SET_TOTAL", 0);

      commit("SET_SHOW", true);
      commit("SET_TEXT", res.data.data.Error);
      commit("SET_COLOR", "red");
    }
  },

  async getMovieByIMDBId({ commit }, payload) {
    console.log(payload, "from imdb store");
    const res = await getMovieByIMDBIdApi(payload);

    console.log(res, "from api", res);
    if ("status" in res && res.status === 200) {
      commit("SET_MOVIE", res.data.data);
    }
  },

  async getSimilarMovies({ commit }, payload) {
    console.log(payload, "from common store");
    const res = await getSimilarMoviesApi(payload?.Type);

    console.log(res, "from res");
    if ("status" in res && res.data.status === 200 && res.data.data.Response) {
      console.log(res.data.data.Search, "from search");
      commit("SET_MOVIES", res.data.data.Search);
      commit("SET_TOTAL", res.data.data.totalResults);
    } else {
      commit("SET_ERROR", res.data.data.Error);
      commit("SET_MOVIES", res.data.data.Search);
      commit("SET_TOTAL", res.data.data.totalResults);
    }
  },

  async register({ commit }, payload) {
    const res = await registerApi(payload);

    console.log(res, "from res");
    if (res.data.status != 200) throw res.data.message;

    // showing message
    commit("SET_SHOW", true);
    commit("SET_TEXT", res.data.message);
    commit("SET_COLOR", "success");

    setTimeout(() => {
      // storing user details on localstorage
      const user = { email: res.data.data.email, token: res.data.data.token };
      localStorage.setItem("user", JSON.stringify(user));

      // setting is login to true
      commit("SET_IS_LOGIN", true);
      commit("SET_USER", user);

      router.push("/");
    }, 2000);
  },

  async login({ commit }, payload) {
    const res = await loginApi(payload);

    if (res.data.status != 200) throw res.data.message;

    // showing message
    commit("SET_SHOW", true);
    commit("SET_TEXT", res.data.message);
    commit("SET_COLOR", "success");

    // redirecting after 2 seconds
    setTimeout(() => {
      // storing user details on localstorage
      const user = { email: res.data.data.email, token: res.data.data.token };
      localStorage.setItem("user", JSON.stringify(user));

      // setting is login to true
      commit("SET_IS_LOGIN", true);
      commit("SET_USER", user);

      router.push("/");
    }, 2000);
  },

  async logout({ commit }) {
    const res = await logoutApi();

    console.log(res, "from common logout");
    if (res.data.status != 200) throw res.data.message;

    commit("SET_SHOW", true);
    commit("SET_TEXT", res.data.message);
    commit("SET_COLOR", "success");

    setTimeout(() => {
      // removing from store user data
      localStorage.removeItem("user");

      // unsetting is login and user
      // setting is login to true
      commit("SET_IS_LOGIN", false);
      router.push("/");
    }, 2000);
  },

  async addFavourite({ commit }, payload) {
    const res = await addFavouriteApi(payload);

    if ("status" in res && res.data.status !== 200) throw res.data.message;

    commit("SET_SHOW", true);
    commit("SET_TEXT", res.data.message);
    commit("SET_COLOR", "success");
  },

  async removeFavourite({ commit }, payload) {
    const res = await removeFavouriteApi(payload);

    if ("status" in res && res.data.status !== 200) throw res.data.message;

    commit("SET_SHOW", true);
    commit("SET_TEXT", res.data.message);
    commit("SET_COLOR", "success");
  },

  async getFavourites({ commit }) {
    const res = await getFavouritesApi();

    console.log(res, "from get fav");
    if ("status" in res && res.data.status !== 200) throw res.data.message;

    commit("SET_MOVIES", res.data.data);
  },
};

const getters = {
  getMoviesFromState(state) {
    return state.movies;
  },
  getTotal(state) {
    return state.total;
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};

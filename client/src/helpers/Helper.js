import store from "@/store";
import axios from "axios";

export const getMoviesApi = async (payload) => {
  return await axios.get("http://localhost:8000/api/movie/", {
    params: payload,
  });
};

export const getMovieByIMDBIdApi = async (payload) => {
  return await axios.get(`http://localhost:8000/api/movie/${payload}`);
};

export const getSimilarMoviesApi = async (payload) => {
  return await axios.get(`http://localhost:8000/api/movie/similar/${payload}`);
};

export const registerApi = async (payload) => {
  return await axios.post(`http://localhost:8000/api/auth/register`, payload);
};

export const loginApi = async (payload) => {
  return await axios.post(`http://localhost:8000/api/auth/login`, payload);
};

export const logoutApi = async () => {
  let token = JSON.parse(localStorage.getItem("user"))["token"];

  return await axios.post("http://localhost:8000/api/auth/logout", null, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

export const addFavouriteApi = async (payload) => {
  let token = JSON.parse(localStorage.getItem("user"))["token"];
  let addData = JSON.parse(localStorage.getItem("similar"));
  delete addData.imdbID;

  let params = {
    title: addData.Title,
    year: addData.Year,
    type: addData.Type,
    poster: addData.Poster,
  };

  return await axios.post(
    `http://localhost:8000/api/movie/add/${payload}`,
    params,
    {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );
};

export const removeFavouriteApi = async (payload) => {
  let token = JSON.parse(localStorage.getItem("user"))["token"];

  return await axios.delete(
    `http://localhost:8000/api/movie/delete/${payload}`,
    {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );
};

export const getFavouritesApi = async () => {
  let token = JSON.parse(localStorage.getItem("user"))["token"];
  console.log(token, "token");

  return await axios.post("http://localhost:8000/api/movie/favourite", null, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
};

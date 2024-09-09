import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import axios from 'axios';

const store = createStore({
  state: {
    isLoggedIn: false,
    user: null,
    roles: []
  },
  mutations: {
    SET_LOGIN_STATE(state, isLoggedIn) {
      state.isLoggedIn = isLoggedIn;
    },
    SET_USER(state, user) {
      state.user = user;
    },
    SET_ROLES(state, roles) {
      state.roles = roles;
    },
    LOGOUT(state) {
      state.isLoggedIn = false;
      state.user = null;
      state.roles = [];
    }
  },
  actions: {
    login({ commit }, { user, roles }) {
      commit('SET_LOGIN_STATE', true);
      commit('SET_USER', user);
      commit('SET_ROLES', roles);
    },
    logout({ commit }) {
      commit('LOGOUT');
    },
    async checkAuth({ commit }) {
      try {
          const response = await axios.get('/api/checkAuth');
          if (response.data.authenticated) {
              commit('SET_USER', response.data.user);
          } else {
              commit('LOGOUT');
          }
      } catch (error) {
          commit('LOGOUT');
      }
    }
  },
  getters: {
    isAuthenticated: (state) => state.isLoggedIn,
    getUser: (state) => state.user,
    getRoles: (state) => state.roles
  },
  plugins: [createPersistedState()],
});

export default store;
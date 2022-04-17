import {createStore} from 'vuex'
import backendUrls from "./backendUrls";

const store = createStore({
    state() {
        return {
            teams: [],
            rounds: [],
        }
    },
    mutations: {
        setTeams(state, teams) {
            state.teams = teams;
        },
        setFixturesList(state, fixtures) {
            state.rounds = fixtures;
        }
    },
    getters: {
        getTeams: state => state.teams,
        getRounds: state => state.rounds,
    },
    actions: {
        async fetchAllTeams({ commit }) {
            const res = await window.axios.get(`${backendUrls.base}/${backendUrls.teams.all}`);
            commit('setTeams', res.data);
        },
        async fetchFixturesForSelectedTeams({ commit }, teamIds) {
            const res = await window.axios.post(`${backendUrls.base}/${backendUrls.fixtures.calculate}`, {
                teams_ids: teamIds
            });
            commit('setFixturesList', res.data);
        }
    }
});

export default store;

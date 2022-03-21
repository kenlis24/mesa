import Vue from 'vue';
import Vuex from 'vuex';

import axios from "axios";
axios.defaults.withCredentials = true;

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        auth: false,
        roles: "",
    },
    mutations: {
        SET_USER(state, user){
            state.user = user;
            state.auth = Boolean(user);
        },
        SET_ROLES(state, roles){
            state.roles = roles;
        },
    },
    actions: {
        async login({ dispatch}, credenciales){
            await axios.get("./sanctum/csrf-cookie");
            await axios.post("./login", credenciales).then(() => {
                dispatch("getUser");
                return dispatch("getRoles");
            });

        },
        async logout({ dispatch}, credenciales){
            await axios.post("./logout").then(() => {
                return dispatch("getUser");
            });

        },
        getUser({commit}){
            axios.get('./api/user').then(res => {
                commit("SET_USER",res.data);
            }).catch(() =>{
                commit("SET_USER",null);
            });
        },
        getRoles({commit}){
            axios.get('./getroles').then(res => {
                commit("SET_ROLES",res.data.permisosuser);
            }).catch(() =>{
                commit("SET_ROLES",null);
            });
        },
    },
    modules: {}
});
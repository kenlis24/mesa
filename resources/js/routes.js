import Vue from 'vue'
import Router from 'vue-router';

Vue.use(Router);

const routes = [
    {
        name: 'registrar',
        path: '/registrar',
        component: () => import(
            /* webpackChunkName: 'js/compiled/registrar' */ './components/Registrar'
        ),
    },
    {
        name: 'users',
        path: '/users',
        component: () => import(
            /* webpackChunkName: 'js/compiled/users' */ './components/admin/Index'
        ),
    },
    {
        name: 'usersedit',
        path: '/users/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/usersedit' */ './components/admin/Edit'
        ),
        props: true
    },
    {
        name: 'roles',
        path: '/roles',
        component: () => import(
            /* webpackChunkName: 'js/compiled/roles' */ './components/admin/Role'
        ),
    },
    {
        name: 'rolesregist',
        path: '/rolesregist',
        component: () => import(
            /* webpackChunkName: 'js/compiled/rolesregist' */ './components/admin/RegistrarRol'
        ),
    },
    {
        name: 'rolesedit',
        path: '/roles/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/rolesedit' */ './components/admin/EditRol'
        ),
        props: true
    },
    {
        name: 'indexprogra',
        path: '/indexprogra',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexprogra' */ './components/usuario/IndexProgra'
        ),
    },
    {
        name: 'programar',
        path: '/programar',
        component: () => import(
            /* webpackChunkName: 'js/compiled/programar' */ './components/usuario/Programar'
        ),
    },
    {
        name: 'programaedit',
        path: '/programaedit/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/programaedit' */ './components/usuario/ProgramaEdit'
        ),
        props: true
    },
]

export default new Router({
    mode: 'abstract',
    base: 'mesa/public',
    routes
});
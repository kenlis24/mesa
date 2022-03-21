import Vue from 'vue'
import Router from 'vue-router';
import registrar from './components/Registrar';
import users from './components/admin/Index';
import usersedit from './components/admin/Edit';
import roles from './components/admin/Role';
import rolesregist from './components/admin/RegistrarRol';
import rolesedit from './components/admin/EditRol';

Vue.use(Router);

const routes = [
    {
        name: 'registrar',
        path: '/registrar',
        component: registrar
    },
    {
        name: 'users',
        path: '/users',
        component: users
    },
    {
        name: 'usersedit',
        path: '/users/:id',
        component: usersedit,
        props: true
    },
    {
        name: 'roles',
        path: '/roles',
        component: roles
    },
    {
        name: 'rolesregist',
        path: '/rolesregist',
        component: rolesregist
    },
    {
        name: 'rolesedit',
        path: '/roles/:id',
        component: rolesedit,
        props: true
    },
]

export default new Router({
    mode: 'abstract',
    base: 'auth/public',
    routes
});
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
        name: 'changepass',
        path: '/changepass/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/changepass' */ './components/admin/ChangePass'
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
    {
        name: 'indexproflota',
        path: '/indexproflota',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexproflota' */ './components/usuario/IndexProFlota'
        ),
    },
    {
        name: 'progfloasig',
        path: '/progfloasig/:prog/:insti/:tipo',
        component: () => import(
            /* webpackChunkName: 'js/compiled/progfloasig' */ './components/usuario/ProgFloAsig'
        ),
        props: true
    },
    {
        name: 'indextrabajador',
        path: '/indextrabajador',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indextrabajador' */ './components/usuario/IndexTrabajador'
        ),
    },
    {
        name: 'trabajadorregist',
        path: '/trabajadorregist',
        component: () => import(
            /* webpackChunkName: 'js/compiled/trabajadorregist' */ './components/usuario/TrabajadorRegist'
        ),
    },
    {
        name: 'trabajadoredit',
        path: '/trabajadoredit/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/trabajadoredit' */ './components/usuario/TrabajadorEdit'
        ),
        props: true
    },
    {
        name: 'indexpersona',
        path: '/indexpersona',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexpersona' */ './components/usuario/IndexPersona'
        ),
    },
    {
        name: 'personaregist',
        path: '/personaregist',
        component: () => import(
            /* webpackChunkName: 'js/compiled/personaregist' */ './components/usuario/PersonaRegist'
        ),
    },
        {
        name: 'personaedit',
        path: '/personaedit/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/personaedit' */ './components/usuario/PersonaEdit'
        ),
        props: true
    },
    {
        name: 'indexvehiculo',
        path: '/indexvehiculo',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexvehiculo' */ './components/usuario/IndexVehiculo'
        ),
    },
    {
        name: 'vehiculoedit',
        path: '/vehiculoedit/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/vehiculoedit' */ './components/usuario/VehiculoEdit'
        ),
        props: true
    },
    {
        name: 'vehiregis',
        path: '/vehiregis',
        component: () => import(
            /* webpackChunkName: 'js/compiled/vehiregis' */ './components/usuario/VehiRegis'
        ),
    },
    {
        name: 'asigvehi',
        path: '/asigvehi/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/asigvehi' */ './components/usuario/AsigVehi'
        ),
        props: true,
    },
    {
        name: 'persoinsti',
        path: '/personsti/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/persoinsti' */ './components/usuario/PersoInsti'
        ),
        props: true,
    },
    {
        name: 'indexproflotarep',
        path: '/indexproflotarep/:fecha',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexproflotarep' */ './components/usuario/IndexProFlotaRep'
        ),
        props: true
    },
    {
        name: 'reporteproflota',
        path: '/reporteproflota',
        component: () => import(
            /* webpackChunkName: 'js/compiled/reporteproflota' */ './components/usuario/ReporteProFlota'
        ),
    },
    {
        name: 'indexinsti',
        path: '/indexinsti',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexinsti' */ './components/usuario/IndexInsti'
        ),
    },
    {
        name: 'institucion',
        path: '/institucion',
        component: () => import(
            /* webpackChunkName: 'js/compiled/institucion' */ './components/usuario/Institucion'
        ),
    },
    {
        name: 'instiedit',
        path: '/instiedit',
        component: () => import(
            /* webpackChunkName: 'js/compiled/instiedit' */ './components/usuario/InstiEdit'
        ),
        props: true,
    },
    {
        name: 'indexasiginsti',
        path: '/indexasiginsti',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexasiginsti' */ './components/admin/IndexAsigInsti'
            ),
    },
    {
        name: 'asiginsti',
        path: '/asiginsti/:id',
        component: () => import(
            /* webpackChunkName: 'js/compiled/asiginsti' */ './components/admin/AsigInsti'
        ),
        props: true,
    },
    {
        name: 'indexdespacho',
        path: '/indexdespacho',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexdespacho' */ './components/usuario/IndexDespacho'
        ),
    },
    {
        name: 'indexdespaxesta',
        path: '/indexdespaxesta',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexdespaxesta' */ './components/usuario/IndexDespaxEsta'
        ),
    },
    {
        name: 'indexdespaxestarep',
        path: '/indexdespaxestarep',
        component: () => import(
            /* webpackChunkName: 'js/compiled/indexdespaxestarep' */ './components/usuario/IndexDespaxEstaRep'
        ),
    },
    {
        name: 'despasig',
        path: '/despasig/:prog/:insti/:tipo',
        component: () => import(
            /* webpackChunkName: 'js/compiled/despasig' */ './components/usuario/DespAsig'
        ),
        props: true,
    },
    {
        name: 'despasigxesta',
        path: '/despasigxesta/:fecha/:insti',
        component: () => import(
            /* webpackChunkName: 'js/compiled/despasigxesta' */ './components/usuario/DespAsigxEsta'
        ),
        props: true,
    },
    {
        name: 'despasigxestarep',
        path: '/despasigxestarep/:fecha/:insti',
        component: () => import(
            /* webpackChunkName: 'js/compiled/despasigxestarep' */ './components/usuario/DespAsigxEstaRep'
        ),
        props: true,
    },
]

export default new Router({
    mode: 'abstract',
    base: 'mesa/public',
    routes
});
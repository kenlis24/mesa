"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["js/compiled/usersedit"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "edituser",
  props: ["id"],
  data: function data() {
    return {
      datos: "",
      snackbar: false,
      color: "",
      roles: [],
      mensaje: "",
      nuevosroles: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get("./users/".concat(this.id, "/edit")).then(function (res) {
      _this.roles = res.data.roles.map(function (rol) {
        var nuevoper = res.data.permisos.find(function (el) {
          return el === rol.name;
        });
        if (nuevoper) _this.nuevosroles.push(rol.name);
        return {
          id: rol.id,
          name: rol.name,
          existe: nuevoper ? true : false
        };
      });
      _this.datos = res.data;
    })["catch"](function (er) {
      _this.datos = er;
    });
  },
  methods: {
    regresar: function regresar() {
      var _this2 = this;

      setTimeout(function () {
        return _this2.$router.push({
          name: "users"
        });
      }, 2800);
    },
    asignar: function asignar() {
      var _this3 = this;

      var rol = {
        roles: this.nuevosroles
      };
      axios.put("./users/".concat(this.id), rol).then(function (res) {
        _this3.color = "success";
        _this3.mensaje = res.data.mensaje;
        _this3.snackbar = true;

        _this3.regresar();
      })["catch"](function (er) {
        _this3.color = "red accent-2";
        _this3.mensaje = er;
        _this3.snackbar = true;
      }); //this.$router.push("users");
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".theme--light.v-data-table {\n  background-color: #FFFFFF;\n  color: rgba(0, 0, 0, 0.87);\n}\n.theme--light.v-data-table .v-data-table__divider {\n  border-right: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table.v-data-table--fixed-header thead th {\n  background: #FFFFFF;\n  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr > th {\n  color: rgba(0, 0, 0, 0.6);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:not(.v-data-table__mobile-row),\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:not(.v-data-table__mobile-row) {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:last-child,\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:last-child {\n  border-bottom: thin solid rgba(0, 0, 0, 0.12);\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr.active {\n  background: #f5f5f5;\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {\n  background: #eeeeee;\n}\n.theme--light.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td:not(.v-data-table__mobile-row),\n.theme--light.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th:not(.v-data-table__mobile-row) {\n  border-top: thin solid rgba(0, 0, 0, 0.12);\n}\n\n.theme--dark.v-data-table {\n  background-color: #1E1E1E;\n  color: #FFFFFF;\n}\n.theme--dark.v-data-table .v-data-table__divider {\n  border-right: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table.v-data-table--fixed-header thead th {\n  background: #1E1E1E;\n  box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > thead > tr > th {\n  color: rgba(255, 255, 255, 0.7);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:not(.v-data-table__mobile-row),\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:not(.v-data-table__mobile-row) {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > td:last-child,\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:not(:last-child) > th:last-child {\n  border-bottom: thin solid rgba(255, 255, 255, 0.12);\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr.active {\n  background: #505050;\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tbody > tr:hover:not(.v-data-table__expanded__content):not(.v-data-table__empty-wrapper) {\n  background: #616161;\n}\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td:not(.v-data-table__mobile-row),\n.theme--dark.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th:not(.v-data-table__mobile-row) {\n  border-top: thin solid rgba(255, 255, 255, 0.12);\n}\n\n.v-data-table {\n  line-height: 1.5;\n  max-width: 100%;\n}\n.v-data-table > .v-data-table__wrapper > table {\n  width: 100%;\n  border-spacing: 0;\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  padding: 0 16px;\n  transition: height 0.2s cubic-bezier(0.4, 0, 0.6, 1);\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  -webkit-user-select: none;\n     -moz-user-select: none;\n      -ms-user-select: none;\n          user-select: none;\n  font-size: 0.75rem;\n  height: 48px;\n}\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-application--is-ltr .v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  text-align: left;\n}\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > tbody > tr > th,\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > thead > tr > th,\n.v-application--is-rtl .v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {\n  text-align: right;\n}\n.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td {\n  font-size: 0.875rem;\n  height: 48px;\n}\n\n.v-data-table__wrapper {\n  overflow-x: auto;\n  overflow-y: hidden;\n}\n\n.v-data-table__progress {\n  height: auto !important;\n}\n.v-data-table__progress th {\n  height: auto !important;\n  border: none !important;\n  padding: 0;\n  position: relative;\n}\n\n.v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > td,\n.v-data-table--dense > .v-data-table__wrapper > table > thead > tr > td,\n.v-data-table--dense > .v-data-table__wrapper > table > tfoot > tr > td {\n  height: 32px;\n}\n.v-data-table--dense > .v-data-table__wrapper > table > tbody > tr > th,\n.v-data-table--dense > .v-data-table__wrapper > table > thead > tr > th,\n.v-data-table--dense > .v-data-table__wrapper > table > tfoot > tr > th {\n  height: 32px;\n}\n\n.v-data-table--has-top > .v-data-table__wrapper > table > tbody > tr:first-child:hover > td:first-child {\n  border-top-left-radius: 0;\n}\n.v-data-table--has-top > .v-data-table__wrapper > table > tbody > tr:first-child:hover > td:last-child {\n  border-top-right-radius: 0;\n}\n\n.v-data-table--has-bottom > .v-data-table__wrapper > table > tbody > tr:last-child:hover > td:first-child {\n  border-bottom-left-radius: 0;\n}\n.v-data-table--has-bottom > .v-data-table__wrapper > table > tbody > tr:last-child:hover > td:last-child {\n  border-bottom-right-radius: 0;\n}\n\n.v-data-table--fixed-height .v-data-table__wrapper {\n  overflow-y: auto;\n}\n\n.v-data-table--fixed-header > .v-data-table__wrapper {\n  overflow-y: auto;\n}\n.v-data-table--fixed-header > .v-data-table__wrapper > table > thead > tr > th {\n  border-bottom: 0px !important;\n  position: -webkit-sticky;\n  position: sticky;\n  top: 0;\n  z-index: 2;\n}\n.v-data-table--fixed-header > .v-data-table__wrapper > table > thead > tr:nth-child(2) > th {\n  top: 48px;\n}\n.v-application--is-ltr .v-data-table--fixed-header .v-data-footer {\n  margin-right: 17px;\n}\n.v-application--is-rtl .v-data-table--fixed-header .v-data-footer {\n  margin-left: 17px;\n}\n\n.v-data-table--fixed-header.v-data-table--dense > .v-data-table__wrapper > table > thead > tr:nth-child(2) > th {\n  top: 32px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass":
/*!**************************************************************************!*\
  !*** ./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!../../../../postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!../../../../sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./VSimpleTable.sass */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-15[0].rules[0].use[3]!./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_1_postcss_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_2_sass_loader_dist_cjs_js_clonedRuleSet_15_0_rules_0_use_3_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/admin/Edit.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/admin/Edit.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Edit.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Edit.vue?vue&type=template&id=737a4475& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.datos
    ? _c(
        "v-container",
        [
          _c(
            "v-btn",
            {
              attrs: { outlined: "", color: "indigo" },
              on: {
                click: function ($event) {
                  return _vm.asignar()
                },
              },
            },
            [_vm._v("Aceptar")]
          ),
          _vm._v(" "),
          _c(
            "v-card",
            { staticClass: "elevation-12" },
            [
              _c(
                "v-toolbar",
                { attrs: { color: "primary", dark: "", flat: "" } },
                [
                  _c("v-toolbar-title", [_vm._v("Asignar roles")]),
                  _vm._v(" "),
                  _c("v-spacer"),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-card-text",
                [
                  _c("label", [
                    _vm._v("Nombre\n        "),
                    _c("span", { staticClass: "d-flex flex-row mb-6" }, [
                      _c("b", [_vm._v(_vm._s(_vm.datos.user.name))]),
                    ]),
                  ]),
                  _vm._v(" "),
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c("label", [
                    _vm._v("Email\n        "),
                    _c("span", { staticClass: "d-flex flex-row mb-6" }, [
                      _c("b", [_vm._v(_vm._s(_vm.datos.user.email))]),
                    ]),
                  ]),
                  _vm._v(" "),
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c("v-simple-table", {
                    attrs: { "fixed-header": "", height: "200px", dense: "" },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "default",
                          fn: function () {
                            return [
                              _c("thead", [
                                _c("tr", [
                                  _c("th", { staticClass: "text-left" }, [
                                    _vm._v("Roles"),
                                  ]),
                                  _vm._v(" "),
                                  _c("th", { staticClass: "text-left" }, [
                                    _vm._v("Activo"),
                                  ]),
                                ]),
                              ]),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                _vm._l(_vm.roles, function (item) {
                                  return _c("tr", { key: item.id }, [
                                    _c("td", [_vm._v(_vm._s(item.name))]),
                                    _vm._v(" "),
                                    _c("td", [
                                      item.existe
                                        ? _c("span", { staticClass: "ml-3" }, [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value: _vm.nuevosroles,
                                                  expression: "nuevosroles",
                                                },
                                              ],
                                              attrs: {
                                                type: "checkbox",
                                                id: item.id,
                                              },
                                              domProps: {
                                                value: item.name,
                                                checked: Array.isArray(
                                                  _vm.nuevosroles
                                                )
                                                  ? _vm._i(
                                                      _vm.nuevosroles,
                                                      item.name
                                                    ) > -1
                                                  : _vm.nuevosroles,
                                              },
                                              on: {
                                                change: function ($event) {
                                                  var $$a = _vm.nuevosroles,
                                                    $$el = $event.target,
                                                    $$c = $$el.checked
                                                      ? true
                                                      : false
                                                  if (Array.isArray($$a)) {
                                                    var $$v = item.name,
                                                      $$i = _vm._i($$a, $$v)
                                                    if ($$el.checked) {
                                                      $$i < 0 &&
                                                        (_vm.nuevosroles =
                                                          $$a.concat([$$v]))
                                                    } else {
                                                      $$i > -1 &&
                                                        (_vm.nuevosroles = $$a
                                                          .slice(0, $$i)
                                                          .concat(
                                                            $$a.slice($$i + 1)
                                                          ))
                                                    }
                                                  } else {
                                                    _vm.nuevosroles = $$c
                                                  }
                                                },
                                              },
                                            }),
                                          ])
                                        : _c("span", { staticClass: "ml-3" }, [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value: _vm.nuevosroles,
                                                  expression: "nuevosroles",
                                                },
                                              ],
                                              attrs: {
                                                type: "checkbox",
                                                id: item.id,
                                              },
                                              domProps: {
                                                value: item.name,
                                                checked: Array.isArray(
                                                  _vm.nuevosroles
                                                )
                                                  ? _vm._i(
                                                      _vm.nuevosroles,
                                                      item.name
                                                    ) > -1
                                                  : _vm.nuevosroles,
                                              },
                                              on: {
                                                change: function ($event) {
                                                  var $$a = _vm.nuevosroles,
                                                    $$el = $event.target,
                                                    $$c = $$el.checked
                                                      ? true
                                                      : false
                                                  if (Array.isArray($$a)) {
                                                    var $$v = item.name,
                                                      $$i = _vm._i($$a, $$v)
                                                    if ($$el.checked) {
                                                      $$i < 0 &&
                                                        (_vm.nuevosroles =
                                                          $$a.concat([$$v]))
                                                    } else {
                                                      $$i > -1 &&
                                                        (_vm.nuevosroles = $$a
                                                          .slice(0, $$i)
                                                          .concat(
                                                            $$a.slice($$i + 1)
                                                          ))
                                                    }
                                                  } else {
                                                    _vm.nuevosroles = $$c
                                                  }
                                                },
                                              },
                                            }),
                                          ]),
                                    ]),
                                  ])
                                }),
                                0
                              ),
                            ]
                          },
                          proxy: true,
                        },
                      ],
                      null,
                      false,
                      393950806
                    ),
                  }),
                ],
                1
              ),
              _vm._v(" "),
              _c("v-card-actions", [_c("v-spacer")], 1),
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-snackbar",
            {
              attrs: {
                timeout: 2500,
                absolute: "",
                color: _vm.color,
                rounded: "pill",
                right: "",
              },
              model: {
                value: _vm.snackbar,
                callback: function ($$v) {
                  _vm.snackbar = $$v
                },
                expression: "snackbar",
              },
            },
            [_vm._v("\n    " + _vm._s(this.mensaje) + "\n  ")]
          ),
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/Edit.vue":
/*!************************************************!*\
  !*** ./resources/js/components/admin/Edit.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=737a4475& */ "./resources/js/components/admin/Edit.vue?vue&type=template&id=737a4475&");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/Edit.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/VBtn.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VContainer.js");
/* harmony import */ var vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VDataTable */ "./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js");
/* harmony import */ var vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VSnackbar */ "./node_modules/vuetify/lib/components/VSnackbar/VSnackbar.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VSpacer.js");
/* harmony import */ var vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VToolbar */ "./node_modules/vuetify/lib/components/VToolbar/VToolbar.js");
/* harmony import */ var vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vuetify/lib/components/VToolbar */ "./node_modules/vuetify/lib/components/VToolbar/index.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Edit_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__.render,
  _Edit_vue_vue_type_template_id_737a4475___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */
;










_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__["default"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__["default"],VCardActions: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardActions,VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardText,VContainer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__["default"],VSimpleTable: vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_8__["default"],VSnackbar: vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_9__["default"],VSpacer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_10__["default"],VToolbar: vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_11__["default"],VToolbarTitle: vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_12__.VToolbarTitle})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/Edit.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js":
/*!************************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VDataTable/VSimpleTable.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _src_components_VDataTable_VSimpleTable_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../src/components/VDataTable/VSimpleTable.sass */ "./node_modules/vuetify/src/components/VDataTable/VSimpleTable.sass");
/* harmony import */ var _util_helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../util/helpers */ "./node_modules/vuetify/lib/util/helpers.js");
/* harmony import */ var _mixins_themeable__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../mixins/themeable */ "./node_modules/vuetify/lib/mixins/themeable/index.js");
/* harmony import */ var _util_mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../util/mixins */ "./node_modules/vuetify/lib/util/mixins.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_util_mixins__WEBPACK_IMPORTED_MODULE_1__["default"])(_mixins_themeable__WEBPACK_IMPORTED_MODULE_2__["default"]).extend({
  name: 'v-simple-table',
  props: {
    dense: Boolean,
    fixedHeader: Boolean,
    height: [Number, String]
  },
  computed: {
    classes() {
      return {
        'v-data-table--dense': this.dense,
        'v-data-table--fixed-height': !!this.height && !this.fixedHeader,
        'v-data-table--fixed-header': this.fixedHeader,
        'v-data-table--has-top': !!this.$slots.top,
        'v-data-table--has-bottom': !!this.$slots.bottom,
        ...this.themeClasses
      };
    }

  },
  methods: {
    genWrapper() {
      return this.$slots.wrapper || this.$createElement('div', {
        staticClass: 'v-data-table__wrapper',
        style: {
          height: (0,_util_helpers__WEBPACK_IMPORTED_MODULE_3__.convertToUnit)(this.height)
        }
      }, [this.$createElement('table', this.$slots.default)]);
    }

  },

  render(h) {
    return h('div', {
      staticClass: 'v-data-table',
      class: this.classes
    }, [this.$slots.top, this.genWrapper(), this.$slots.bottom]);
  }

}));
//# sourceMappingURL=VSimpleTable.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VGrid/VContainer.js":
/*!*****************************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VGrid/VContainer.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _src_components_VGrid_grid_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../src/components/VGrid/_grid.sass */ "./node_modules/vuetify/src/components/VGrid/_grid.sass");
/* harmony import */ var _src_components_VGrid_VGrid_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../src/components/VGrid/VGrid.sass */ "./node_modules/vuetify/src/components/VGrid/VGrid.sass");
/* harmony import */ var _grid__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./grid */ "./node_modules/vuetify/lib/components/VGrid/grid.js");
/* harmony import */ var _util_mergeData__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../util/mergeData */ "./node_modules/vuetify/lib/util/mergeData.js");




/* @vue/component */

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_grid__WEBPACK_IMPORTED_MODULE_2__["default"])('container').extend({
  name: 'v-container',
  functional: true,
  props: {
    id: String,
    tag: {
      type: String,
      default: 'div'
    },
    fluid: {
      type: Boolean,
      default: false
    }
  },

  render(h, {
    props,
    data,
    children
  }) {
    let classes;
    const {
      attrs
    } = data;

    if (attrs) {
      // reset attrs to extract utility clases like pa-3
      data.attrs = {};
      classes = Object.keys(attrs).filter(key => {
        // TODO: Remove once resolved
        // https://github.com/vuejs/vue/issues/7841
        if (key === 'slot') return false;
        const value = attrs[key]; // add back data attributes like data-test="foo" but do not
        // add them as classes

        if (key.startsWith('data-')) {
          data.attrs[key] = value;
          return false;
        }

        return value || typeof value === 'string';
      });
    }

    if (props.id) {
      data.domProps = data.domProps || {};
      data.domProps.id = props.id;
    }

    return h(props.tag, (0,_util_mergeData__WEBPACK_IMPORTED_MODULE_3__["default"])(data, {
      staticClass: 'container',
      class: Array({
        'container--fluid': props.fluid
      }).concat(classes || [])
    }), children);
  }

}));
//# sourceMappingURL=VContainer.js.map

/***/ }),

/***/ "./node_modules/vuetify/lib/components/VGrid/grid.js":
/*!***********************************************************!*\
  !*** ./node_modules/vuetify/lib/components/VGrid/grid.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ VGrid)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");
// Types

function VGrid(name) {
  /* @vue/component */
  return vue__WEBPACK_IMPORTED_MODULE_0__["default"].extend({
    name: `v-${name}`,
    functional: true,
    props: {
      id: String,
      tag: {
        type: String,
        default: 'div'
      }
    },

    render(h, {
      props,
      data,
      children
    }) {
      data.staticClass = `${name} ${data.staticClass || ''}`.trim();
      const {
        attrs
      } = data;

      if (attrs) {
        // reset attrs to extract utility clases like pa-3
        data.attrs = {};
        const classes = Object.keys(attrs).filter(key => {
          // TODO: Remove once resolved
          // https://github.com/vuejs/vue/issues/7841
          if (key === 'slot') return false;
          const value = attrs[key]; // add back data attributes like data-test="foo" but do not
          // add them as classes

          if (key.startsWith('data-')) {
            data.attrs[key] = value;
            return false;
          }

          return value || typeof value === 'string';
        });
        if (classes.length) data.staticClass += ` ${classes.join(' ')}`;
      }

      if (props.id) {
        data.domProps = data.domProps || {};
        data.domProps.id = props.id;
      }

      return h(props.tag, data, children);
    }

  });
}
//# sourceMappingURL=grid.js.map

/***/ })

}]);
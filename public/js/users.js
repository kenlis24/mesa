"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["users"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "userindex",
  data: function data() {
    return {
      snackbar: false,
      mensaje: "",
      id: "",
      color: "",
      dialog: false,
      datos: [],
      create: false,
      headers: [{
        text: "ID",
        align: "start",
        sortable: false,
        value: "id"
      }, {
        text: "Nombre",
        value: "name"
      }, {
        text: "Correo",
        value: "email"
      }, {
        text: "Acciones",
        value: ""
      }]
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get("./users").then(function (res) {
      //this.datos = res.data;
      _this.datos = res.data.usuarios.map(function (usu) {
        var edit = res.data.permisosuser.find(function (el) {
          return el.name === "admin.user.edit";
        });
        var eliminar = res.data.permisosuser.find(function (el) {
          return el.name === "admin.user.destroy";
        });
        var crear = res.data.permisosuser.find(function (el) {
          return el.name === "admin.user.create";
        });
        if (crear) _this.create = true;
        return {
          id: usu.id,
          name: usu.name,
          email: usu.email,
          editar: edit ? true : false,
          eliminar: eliminar ? true : false
        };
      }); //window.location.reload();
    })["catch"](function (er) {
      _this.color = "red accent-2";
      _this.mensaje = er;
      _this.snackbar = true;
    });
  },
  methods: {
    editar: function editar(id) {
      this.$router.push({
        name: "usersedit",
        params: {
          id: id
        }
      });
    },
    eliminar: function eliminar(id) {
      this.id = id;
      this.dialog = true;
    },
    eliminarusuario: function eliminarusuario() {
      var _this2 = this;

      axios["delete"]("./users/".concat(this.id)).then(function (res) {
        _this2.color = "success";
        _this2.mensaje = res.data.mensaje;
        _this2.snackbar = true;
        _this2.dialog = false;

        _this2.cargar();
      })["catch"](function (er) {
        _this2.color = "red accent-2";
        _this2.mensaje = er;
        _this2.snackbar = true;
      });
    },
    registrar: function registrar() {
      this.$router.push({
        name: "registrar"
      });
    },
    cargar: function cargar() {
      var _this3 = this;

      axios.get("./users").then(function (res) {
        //this.datos = res.data;
        _this3.datos = res.data.usuarios.map(function (usu) {
          var edit = res.data.permisosuser.find(function (el) {
            return el.name === "admin.user.edit";
          });
          var eliminar = res.data.permisosuser.find(function (el) {
            return el.name === "admin.user.destroy";
          });
          return {
            id: usu.id,
            name: usu.name,
            email: usu.email,
            editar: edit ? true : false,
            eliminar: eliminar ? true : false
          };
        }); //window.location.reload();
      })["catch"](function (er) {
        _this3.color = "red accent-2";
        _this3.mensaje = er;
        _this3.snackbar = true;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/admin/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/admin/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=3d8603f7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  return _vm.$store.state.auth
    ? _c(
        "v-container",
        { staticClass: "fill-height", attrs: { fluid: "" } },
        [
          _c(
            "v-row",
            { attrs: { align: "center", justify: "center" } },
            [
              _c(
                "v-card",
                { staticClass: "mt-12 mx-auto" },
                [
                  _c(
                    "div",
                    { staticClass: "text-right" },
                    [
                      _vm.create
                        ? _c(
                            "v-btn",
                            {
                              attrs: { outlined: "", color: "indigo" },
                              on: {
                                click: function ($event) {
                                  return _vm.registrar()
                                },
                              },
                            },
                            [
                              _c("v-icon", { attrs: { dense: "" } }, [
                                _vm._v("mdi-plus"),
                              ]),
                              _vm._v("\n          Registrar\n        "),
                            ],
                            1
                          )
                        : _vm._e(),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("v-data-table", {
                    staticClass: "elevation-1",
                    attrs: {
                      dense: "",
                      headers: _vm.headers,
                      items: _vm.datos,
                      "item-key": "name",
                    },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "item",
                          fn: function (row) {
                            return [
                              _c("tr", [
                                _c("td", [_vm._v(_vm._s(row.item.id))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(row.item.name))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(row.item.email))]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  [
                                    row.item.editar
                                      ? _c(
                                          "v-btn",
                                          {
                                            attrs: { icon: "" },
                                            on: {
                                              click: function ($event) {
                                                return _vm.editar(row.item.id)
                                              },
                                            },
                                          },
                                          [
                                            _c("v-icon", [
                                              _vm._v("mdi-lead-pencil"),
                                            ]),
                                          ],
                                          1
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    row.item.eliminar
                                      ? _c(
                                          "v-btn",
                                          {
                                            attrs: { icon: "" },
                                            on: {
                                              click: function ($event) {
                                                return _vm.eliminar(row.item.id)
                                              },
                                            },
                                          },
                                          [
                                            _c("v-icon", [
                                              _vm._v("mdi-delete"),
                                            ]),
                                          ],
                                          1
                                        )
                                      : _vm._e(),
                                  ],
                                  1
                                ),
                              ]),
                            ]
                          },
                        },
                      ],
                      null,
                      false,
                      128216851
                    ),
                  }),
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
                    [_vm._v("\n        " + _vm._s(this.mensaje) + "\n      ")]
                  ),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-dialog",
                {
                  attrs: { persistent: "", "max-width": "290" },
                  model: {
                    value: _vm.dialog,
                    callback: function ($$v) {
                      _vm.dialog = $$v
                    },
                    expression: "dialog",
                  },
                },
                [
                  _c(
                    "v-card",
                    [
                      _c("v-card-title", { staticClass: "text-h5" }, [
                        _vm._v(" Eliminar usuario "),
                      ]),
                      _vm._v(" "),
                      _c("v-card-text", [
                        _vm._v("Desea eliminar el usuario con sus roles"),
                      ]),
                      _vm._v(" "),
                      _c(
                        "v-card-actions",
                        [
                          _c("v-spacer"),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              attrs: { color: "green darken-1", text: "" },
                              on: {
                                click: function ($event) {
                                  return _vm.eliminarusuario()
                                },
                              },
                            },
                            [_vm._v("\n            Si\n          ")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              attrs: { color: "green darken-2", text: "" },
                              on: {
                                click: function ($event) {
                                  _vm.dialog = false
                                },
                              },
                            },
                            [_vm._v("\n            No\n          ")]
                          ),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/Index.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/admin/Index.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=3d8603f7& */ "./resources/js/components/admin/Index.vue?vue&type=template&id=3d8603f7&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/VBtn.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VContainer.js");
/* harmony import */ var vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VDataTable */ "./node_modules/vuetify/lib/components/VDataTable/VDataTable.js");
/* harmony import */ var vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VDialog */ "./node_modules/vuetify/lib/components/VDialog/VDialog.js");
/* harmony import */ var vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VIcon */ "./node_modules/vuetify/lib/components/VIcon/VIcon.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VRow.js");
/* harmony import */ var vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vuetify/lib/components/VSnackbar */ "./node_modules/vuetify/lib/components/VSnackbar/VSnackbar.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VSpacer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_3d8603f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */
;












_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__["default"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__["default"],VCardActions: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardActions,VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardText,VCardTitle: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardTitle,VContainer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__["default"],VDataTable: vuetify_lib_components_VDataTable__WEBPACK_IMPORTED_MODULE_8__["default"],VDialog: vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_9__["default"],VIcon: vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_10__["default"],VRow: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_11__["default"],VSnackbar: vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_12__["default"],VSpacer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_13__["default"]})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ })

}]);
"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["registrar"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "registrar",
  data: function data() {
    return {
      valido: false,
      snackbar: false,
      mensaje: "",
      user: {},
      nombre: "",
      correo: "",
      color: "",
      mostrarPass: false,
      clave: "",
      clave2: "",
      correoRules: [function (v) {
        return !!v || "El correo es requerido";
      }, function (v) {
        return v.length >= 7 || "El correo es minimo 7 caracteres";
      }, function (v) {
        var pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(v) || "correo no valido";
      }],
      nombreRules: [function (v) {
        return !!v || "Usuario es requerido";
      }, function (v) {
        return v.length >= 3 || "El usuario es minimo 3 caracteres";
      }],
      claveRules: [function (v) {
        return !!v || "La clave es requerida";
      }, function (v) {
        return v.length >= 8 || "La clave debe tener minimo 8 caracteres";
      }]
    };
  },
  methods: {
    validar: function validar() {
      var _this = this;

      var datos = {
        name: this.nombre,
        email: this.correo,
        password: this.clave,
        Password_confirmation: this.clave2 //tipo: this.tipo,

      };

      if (this.clave === this.clave2) {
        axios.post("./registrar", datos).then(function (res) {
          _this.color = "success";
          _this.mensaje = res.data.mensaje;
          _this.snackbar = true;
          _this.nombre = "";
          _this.correo = "";
          _this.clave = "";
          _this.clave2 = ""; //window.location.reload();
        })["catch"](function (er) {
          if (er.toString().includes("422")) _this.mensaje = "El correo ya existe";else _this.mensaje = "No tienes permisos";
          _this.color = "red accent-2";
          _this.snackbar = true;
        });
      } else {
        this.color = "red accent-2";
        this.mensaje = "La clave deben ser iguales";
        this.snackbar = true;
      }

      this.$refs.form.validate();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Registrar.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/Registrar.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Registrar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Registrar.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Registrar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Registrar.vue?vue&type=template&id=6e8e4092& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  return _c(
    "v-container",
    { staticClass: "fill-height", attrs: { fluid: "" } },
    [
      _c(
        "v-row",
        { attrs: { align: "center", justify: "center" } },
        [
          _vm.$store.state.auth
            ? _c(
                "v-card",
                { staticClass: "elevation-12" },
                [
                  _c(
                    "v-toolbar",
                    { attrs: { color: "primary", dark: "", flat: "" } },
                    [
                      _c("v-toolbar-title", [_vm._v("Registrar Usuario")]),
                      _vm._v(" "),
                      _c("v-spacer"),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-card-text",
                    [
                      _c(
                        "v-form",
                        {
                          ref: "form",
                          model: {
                            value: _vm.valido,
                            callback: function ($$v) {
                              _vm.valido = $$v
                            },
                            expression: "valido",
                          },
                        },
                        [
                          _c("v-text-field", {
                            attrs: {
                              rules: _vm.nombreRules,
                              label: "Nombre",
                              required: "",
                            },
                            model: {
                              value: _vm.nombre,
                              callback: function ($$v) {
                                _vm.nombre = $$v
                              },
                              expression: "nombre",
                            },
                          }),
                          _vm._v(" "),
                          _c("v-text-field", {
                            attrs: {
                              rules: _vm.correoRules,
                              label: "Correo",
                              required: "",
                            },
                            model: {
                              value: _vm.correo,
                              callback: function ($$v) {
                                _vm.correo = $$v
                              },
                              expression: "correo",
                            },
                          }),
                          _vm._v(" "),
                          _c("v-text-field", {
                            attrs: {
                              rules: _vm.claveRules,
                              "append-icon": _vm.mostrarPass
                                ? "mdi-eye"
                                : "mdi-eye-off",
                              type: _vm.mostrarPass ? "text" : "password",
                              label: "Clave",
                              required: "",
                            },
                            on: {
                              "click:append": function ($event) {
                                _vm.mostrarPass = !_vm.mostrarPass
                              },
                            },
                            model: {
                              value: _vm.clave,
                              callback: function ($$v) {
                                _vm.clave = $$v
                              },
                              expression: "clave",
                            },
                          }),
                          _vm._v(" "),
                          _c("v-text-field", {
                            attrs: {
                              rules: _vm.claveRules,
                              "append-icon": _vm.mostrarPass
                                ? "mdi-eye"
                                : "mdi-eye-off",
                              type: _vm.mostrarPass ? "text" : "password",
                              label: "repita la clave",
                              required: "",
                            },
                            on: {
                              "click:append": function ($event) {
                                _vm.mostrarPass = !_vm.mostrarPass
                              },
                            },
                            model: {
                              value: _vm.clave2,
                              callback: function ($$v) {
                                _vm.clave2 = $$v
                              },
                              expression: "clave2",
                            },
                          }),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-card-actions",
                    [
                      _c("v-spacer"),
                      _vm._v(" "),
                      _vm.$store.state.auth
                        ? _c(
                            "v-btn",
                            {
                              staticClass: "mr-4",
                              attrs: {
                                disabled: !_vm.valido,
                                color: "primary",
                              },
                              on: { click: _vm.validar },
                            },
                            [_vm._v("\n          Registrar\n        ")]
                          )
                        : _vm._e(),
                    ],
                    1
                  ),
                ],
                1
              )
            : _vm._e(),
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
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Registrar.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/Registrar.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Registrar.vue?vue&type=template&id=6e8e4092& */ "./resources/js/components/Registrar.vue?vue&type=template&id=6e8e4092&");
/* harmony import */ var _Registrar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Registrar.vue?vue&type=script&lang=js& */ "./resources/js/components/Registrar.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/VBtn.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/VCard.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VContainer.js");
/* harmony import */ var vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VForm */ "./node_modules/vuetify/lib/components/VForm/VForm.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VRow.js");
/* harmony import */ var vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VSnackbar */ "./node_modules/vuetify/lib/components/VSnackbar/VSnackbar.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/VSpacer.js");
/* harmony import */ var vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vuetify/lib/components/VTextField */ "./node_modules/vuetify/lib/components/VTextField/VTextField.js");
/* harmony import */ var vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vuetify/lib/components/VToolbar */ "./node_modules/vuetify/lib/components/VToolbar/VToolbar.js");
/* harmony import */ var vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! vuetify/lib/components/VToolbar */ "./node_modules/vuetify/lib/components/VToolbar/index.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Registrar_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__.render,
  _Registrar_vue_vue_type_template_id_6e8e4092___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */
;












_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_4__["default"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_5__["default"],VCardActions: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardActions,VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_6__.VCardText,VContainer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_7__["default"],VForm: vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_8__["default"],VRow: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__["default"],VSnackbar: vuetify_lib_components_VSnackbar__WEBPACK_IMPORTED_MODULE_10__["default"],VSpacer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_11__["default"],VTextField: vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_12__["default"],VToolbar: vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_13__["default"],VToolbarTitle: vuetify_lib_components_VToolbar__WEBPACK_IMPORTED_MODULE_14__.VToolbarTitle})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Registrar.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ })

}]);
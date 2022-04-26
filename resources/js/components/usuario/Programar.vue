<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Programación</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-autocomplete
              v-model="insti"
              :items="institems"
              :rules="instiRules"
              outlined
              dense
              chips
              small-chips
              label="Institución"
              multiple
            ></v-autocomplete>

            <v-autocomplete
              v-model="estaser"
              :items="estaseritems"
              :rules="estaserRules"
              outlined
              dense
              chips
              small-chips
              label="Estación de Servicio"
              multiple
            ></v-autocomplete>
            <v-menu
              ref="fecha"
              v-model="fecha"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              max-width="290px"
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  outlined
                  v-model="dateFormatted"
                  label="Fecha"
                  :rules="fechaRules"
                  hint="DD/MM/YYYY formato"
                  persistent-hint
                  v-bind="attrs"
                  @blur="fechaDesde = parseDate(dateFormatted)"
                  v-on="on"
                  dense
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="fechaDesde"
                no-title
                @input="fecha = false"
              ></v-date-picker>
            </v-menu>
            <v-select
              v-model="tipo"
              :items="tipoitems"
              :rules="tipoRules"
              label="Tipo Combustible"
              required
            ></v-select>
            <v-text-field
              v-model="litros"
              :counter="4"
              :rules="litrosRules"
              max="9999"
              type="number"
              label="Litros"
              required
            ></v-text-field>
            <v-select
              v-model="condi"
              :items="conditems"
              :rules="condiRules"
              label="Condición"
              required
            ></v-select>
            <v-textarea
              counter
              label="Observación"
              :rules="observRules"
              :value="observ"
            ></v-textarea>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            v-if="$store.state.auth"
            :disabled="!valido"
            color="primary"
            class="mr-4"
            @click="validar"
          >
            Registrar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-row>
    <v-snackbar
      :timeout="2500"
      v-model="snackbar"
      absolute
      :color="color"
      rounded="pill"
      right
    >
      {{ this.mensaje }}
    </v-snackbar>
  </v-container>
</template>
<script>
export default {
  name: "regisprog",
  data() {
    return {
      valido: false,
      snackbar: false,
      fecha: false,
      fechaDesde: new Date().toISOString().substr(0, 10),
      dateFormatted: "",
      fromDateVal: null,
      minDate: "2020-01-05",
      maxDate: "2019-08-30",
      color: "",
      mensaje: "",
      institems: ["Unet", "Iut", "alcaldia", "Gobernación"],
      estaseritems: ["temporal"],
      tipoitems: ["Gasolina", "Gasoil"],
      conditems: ["Programado", "Aprobado", "Negado"],
      insti: [],
      estaser: [],
      tipo: "",
      litros: "",
      condi: "",
      observ: "",
      instiRules: [
        (v) => !!v || "Seleccione una institución",
        (v) => v.length >= 1 || "Seleccione una institución",
      ],
      estaserRules: [
        (v) => !!v || "Seleccione una estación",
        (v) => v.length >= 1 || "Seleccione una estación",
      ],
      tipoRules: [
        (v) => !!v || "Seleccione un combustible",
        (v) => v.length >= 1 || "Seleccione un combustible",
      ],
      condiRules: [
        (v) => !!v || "Seleccione una condición",
        (v) => v.length >= 1 || "Seleccione una condición",
      ],
      observRules: [(v) => v.length <= 250 || "Maximo 250 caracteres"],
      litrosRules: [
        (v) => !!v || "Seleccione cantidad de litros",
        (v) => v.length > 0 || "Seleccione cantidad de litros",
        (v) => v <= 9999 || "cantidad maxima 9999",
        (v) => v > 0 || "cantidad de litros debe ser mayor a cero",
      ],
      fechaRules: [(v) => !!v || "Seleccione una fecha"],
    };
  },
  watch: {
    fechaDesde(val) {
      this.dateFormatted = this.formatDate(this.fechaDesde);
    },
  },
  methods: {
    changeLocale() {
      this.$vuetify.lang.current = "es";
    },
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");
      return `${day}/${month}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;

      const [day, month, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
    validar() {
      this.$refs.form.validate();
    },
  },
};
</script>
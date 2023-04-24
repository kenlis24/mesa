<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-card class="elevation-12" v-if="$store.state.auth">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Registrar Despacho</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-title class="text-h5 red lighten-2">
          * Campos obligatorios
        </v-card-title>
        <v-card-text>
          <v-form ref="form" v-model="valido">
            <v-text-field
              v-model="placa"
              :rules="placaRules"
              label="Placa *"
              required
            ></v-text-field>
            <v-autocomplete
              v-model="tipov"
              :items="tipoitemsv"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de vehiculo"
              return-object
            ></v-autocomplete>

            <v-autocomplete
              v-model="tipoc"
              :items="tipoitemsc"
              item-text="nombre"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="Tipo de combustible"
              return-object
            ></v-autocomplete>
            <v-text-field
              label="Litros"
              min="0"
              max="999"
              :rules="litrosRules"
              v-model="litros"
              type="number"
            ></v-text-field>
            <v-text-field
              label="Cédula"
              v-model="cedula"
              :rules="cedulaRules"
              type="number"
            ></v-text-field>
            <v-text-field
              label="Teléfono"
              :rules="telefonoRules"
              v-model="telefono"
              type="number"
            ></v-text-field>
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
      :timeout="3000"
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
  name: "regisInterDespa",
  data() {
    return {
      valido: false,
      snackbar: false,
      color: "",
      mensaje: "",
      placa: "",
      tipov: "",
      tipoitemsv: [
        { id: "1", nombre: "Carro" },
        { id: "2", nombre: "Moto" },
      ],
      tipoitemsc: [
        { id: "1", nombre: "Gasolina" },
        { id: "2", nombre: "Diésel" },
      ],
      tipoc: "",
      litros: "",
      cedula: "",
      telefono: "",
      placaRules: [
        (v) => !!v || "Placa es requerida",
        (v) => v.length >= 5 || "La placa minimo 5 caracteres",
      ],
      litrosRules: [
        (v) => {
          if (v.length == 0) {
            return true;
          } else {
            if (parseInt(v) < 1) {
              return "Los litros no puede ser menor a 0";
            } else {
              if (parseInt(v) > 999) {
                return "Los litros no puede ser mayor a 999";
              } else {
                return true;
              }
            }
          }
        },
      ],
      cedulaRules: [
        (v) => {
          if (v.length == 0) {
            return true;
          } else {
            if (!/^([0-9]{5,8})$/.test(v)) {
              return "solo numeros entre 5 y 8 digitos";
            } else {
              return true;
            }
          }
        },
        //(v) => /^([0-9]{0,8})$/.test(v) || "solo numeros entre 5 y 8 digitos ",
      ],
      telefonoRules: [
        (v) => {
          if (v.length == 0) {
            return true;
          } else {
            if (!/^([0-9]{10})$/.test(v)) {
              return "solo numeros formato ejemplo 4161234567";
            } else {
              return true;
            }
          }
        },
      ],
    };
  },
  methods: {
    validar() {
      var datos = {
        atei_placa: this.placa?.trim().toUpperCase(),
        atei_tipo_vehi: this.tipov.id,
        atei_tipo_comb: this.tipoc.id,
        atei_litros: this.litros,
        atei_cedula: this.cedula,
        atei_telefono: this.telefono,
      };
      axios
        .post(`./internaregist`, datos)
        .then((res) => {
          this.color = "success";
          this.mensaje = res.data.mensaje;
          this.snackbar = true;
          this.placa = "";
          this.tipov = "";
          this.tipoc = "";
          this.litros = "";
          this.cedula = "";
          this.telefono = "";
          this.$refs.form.resetValidation();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er.response.data.mensaje;
          this.placa = "";
          this.tipov = "";
          this.tipoc = "";
          this.litros = "";
          this.cedula = "";
          this.telefono = "";
          this.$refs.form.resetValidation();
          this.snackbar = true;
        });
    },
  },
};
</script>
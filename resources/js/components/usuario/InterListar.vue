<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row justify="center">
      <v-col cols="4">
        <v-card class="mt-12">
          <v-card-title> Buscar Placa </v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="valido">
              <div class="text-center text-h6"></div>
              <v-row align="center">
                <v-col align="center" md="6" sm="12">
                  <v-text-field
                    v-model="placa"
                    :rules="placaRules"
                    label="Placa *"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              v-if="$store.state.auth"
              :disabled="!valido"
              color="primary"
              class="mr-4"
              @click="buscar"
            >
              Buscar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card v-if="datos" class="mt-12">
          <v-card-title> Despachos</v-card-title>
          <v-card-text>
            <v-data-table
              dense
              :headers="headers"
              :items="datos"
              item-key="name"
              class="elevation-1"
            >
              <template v-slot:item="row">
                <tr>
                  <td>{{ row.item.atei_placa }}</td>
                  <td>{{ row.item.atei_fecha }}</td>
                  <td>{{ row.item.estacion }}</td>
                </tr>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-snackbar
      bottom
      :timeout="2500"
      v-model="snackbar"
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
  name: "listarInter",
  data: () => ({
    snackbar: false,
    show: false,
    color: "",
    valido: false,
    placa: "",
    mensaje: "",
    datos: null,
    headers: [
      { text: "Placa", value: "atei_placa" },
      { text: "Fecha", value: "atei_fecha" },
      { text: "Estación", value: "estacion" },
    ],
    placaRules: [(v) => !!v || "Placa es requerida"],
  }),
  methods: {
    buscar() {
      var datos = {
        atei_placa: this.placa?.trim().toUpperCase(),
      };
      axios
        .post("./internalista", datos)
        .then((res) => {
          this.datos = res.data.datos.map((movi) => {
            return {
              atei_placa: movi.atei_placa,
              atei_fecha: movi.atei_fecha,
              estacion: movi.estacion,
            };
          });

          //window.location.reload();
        })
        .catch((er) => {
          this.color = "red accent-2";
          this.mensaje = er.response.data.mensaje;
          this.snackbar = true;
          this.datos = null;
        });
    },
  },
};
</script>
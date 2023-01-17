<template>
  <v-container class="fill-height" fluid v-if="$store.state.auth">
    <v-row align="center" justify="center">
      <v-card class="mt-12 mx-auto">
        <div class="text-center text-h6">DESPACHO COMBUSTIBLE POR ESTACIÓN</div>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          dense
          :headers="headers"
          :items="datos"
          :search="search"
          item-key="name"
          class="elevation-1"
        >
          <template v-slot:item="row">
            <tr>
              <td>{{ row.item.id }}</td>
              <td>{{ row.item.prog_fecha }}</td>
              <td>{{ row.item.estacion }}</td>
              <td>
                <v-tooltip v-if="row.item.asignar" top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      v-bind="attrs"
                      v-on="on"
                      @click="asignar(row.item.prog_fecha, row.item.id)"
                      small
                      >mdi-gas-station-outline</v-icon
                    >
                  </template>
                  <span>Despachado</span>
                </v-tooltip>
              </td>
            </tr>
          </template>
        </v-data-table>
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
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "indexdespaxesta",
  data: () => ({
    snackbar: false,
    mensaje: "",
    search: "",
    id: "",
    color: "",
    datos: [],
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Fecha programación", value: "prog_fecha" },
      { text: "Estación", value: "estacion" },
      { text: "Acciones", value: "" },
    ],
  }),
  mounted() {
    axios
      .get("./programaxesta")
      .then((res) => {
        //this.datos = res.data;

        this.datos = res.data.progra.map((prog) => {
          const asig = res.data.permisosuser.find(
            (el) => el.name === "despaxesta.user.edit"
          );
          return {
            id: prog.esta_id,
            prog_fecha: prog.prog_fecha.slice(0, 10),
            estacion: prog.estacion,
            asignar: asig ? true : false,
          };
        });
        //window.location.reload();
      })
      .catch((er) => {
        this.color = "red accent-2";
        this.mensaje = er;
        this.snackbar = true;
      });
  },
  methods: {
    asignar(fecha, insti) {
      this.$router.push({
        name: "despasigxesta",
        params: { fecha: fecha, insti: insti },
      });
    },
  },
};
</script>